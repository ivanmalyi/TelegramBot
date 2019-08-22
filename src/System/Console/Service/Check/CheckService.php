<?php

declare(strict_types=1);

namespace System\Console\Service\Check;

use System\Console\AbstractService;
use System\Console\Service\Pay\PayStageMessages;
use System\Entity\Component\Billing\BillingAcquiringStatus;
use System\Entity\Component\Billing\BillingResponseCode;
use System\Entity\Component\Billing\BillingResponseStatus;
use System\Entity\Component\Billing\Response\CheckResponse;
use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\Repository\BillingData;
use System\Entity\Repository\Chat;
use System\Entity\Repository\ChatHistory;
use System\Entity\Repository\Payment;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Exception\Protocol\DaemonNotActiveException;
use System\Exception\Protocol\DatabaseDataNotFoundException;
use System\Kernel\Protocol\AnswerMessage;
use System\Kernel\Protocol\CommandLinePacket;
use System\Util\ChatHistory\ChatHistoryTrait;

/**
 * Class CheckService
 * @package System\Console\Service\Check
 */
class CheckService extends AbstractService
{
    use CheckServiceDependenciesTrait;
    use ChatHistoryTrait;

    protected $sleep = 1 * 5;
    protected $serviceName = 'check';

    /**
     * @param CommandLinePacket $packet
     *
     * @return void
     *
     * @throws DaemonNotActiveException
     * @throws \System\Exception\DiException
     */
    protected function doService(CommandLinePacket $packet)
    {
        $this->checkForDaemonIsActive();

        $payments = $this->getPaymentsRepository()->findAllByStatuses([
            Payment::WAITING, Payment::HOLD, Payment::OK_PROVIDER_PAYMENT
        ]);
        foreach ($payments as $payment) {
            try {
                $this->getLogger()->info($payment->__toString(), [
                    'tag' => ['service', 'check_service', 'request']
                ]);
                $checkResponse = $this->getBillingComponent()->check($payment);
                $this->getLogger()->info($checkResponse->__toString(), [
                    'tag' => ['service', 'check_service', 'response']
                ]);

                $this->processCheckResponse($checkResponse, $payment);
            } catch (\Throwable $e) {
                $this->getLogger()->error('CheckService: '.$e->getMessage()."\nFile: ".$e->getFile().
                    '; Line: '.$e->getLine(),
                    ['tag' => ['service', 'check_service', 'error']]
                );
            }
        }
    }

    /**
     * @param CheckResponse $checkResponse
     * @param Payment $payment
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    private function processCheckResponse(CheckResponse $checkResponse, Payment $payment): void
    {
        if ($checkResponse->getResult() === BillingResponseCode::SUCCESS_ACTION) {
            $status = $checkResponse->getStatus();
            $acqStatus = $checkResponse->getAcquiringStatus();

            if ($status === BillingResponseStatus::CANCEL and $acqStatus === BillingAcquiringStatus::CANCEL) {
                $this->getPaymentsRepository()->updateStatus(Payment::CANCEL, $payment->getId());
                $this->saveChatHistory($payment, CheckStageMessages::ANNUL);
                $this->notifyClient($payment, CheckStageMessages::ANNUL);
            } elseif ($status === BillingResponseStatus::CANCEL) {
                if ($status !== $payment->getBillingStatus()) {
                    $this->getPaymentsRepository()->updateStatus(Payment::WAITING, $payment->getId());
                    $this->saveChatHistory($payment, CheckStageMessages::ANNULLING_AFTER_PAYMENT_CANCEL);
                    $this->notifyClient($payment, CheckStageMessages::ANNULLING_AFTER_PAYMENT_CANCEL);
                }
            } elseif ($acqStatus === BillingAcquiringStatus::CANCEL) {
                if ($acqStatus !== $payment->getAcquiringStatus()) {
                    $this->getPaymentsRepository()->updateStatus(Payment::WAITING, $payment->getId());
                    $this->saveChatHistory($payment, CheckStageMessages::CANCELLING_AFTER_FUNDS_ANNUL);
                    $this->notifyClient($payment, CheckStageMessages::CANCELLING_AFTER_FUNDS_ANNUL);
                }
            } elseif ($acqStatus === BillingAcquiringStatus::COMPLETE) {
                $this->getPaymentsRepository()->updateStatus(Payment::COMPLETE, $payment->getId());
                $this->saveChatHistory($payment, CheckStageMessages::COMPLETE);
                $this->notifyClient($payment, CheckStageMessages::COMPLETE);
            } elseif ($status === BillingResponseStatus::OK and $acqStatus === BillingAcquiringStatus::HOLD) {
                if ($status !== $payment->getBillingStatus()) {
                    $this->getPaymentsRepository()->updateStatus(Payment::OK_PROVIDER_PAYMENT, $payment->getId());
                    $this->saveChatHistory($payment, PayStageMessages::PAYMENT_OK, Stage::PAY);
                    $this->notifyClient($payment, PayStageMessages::PAYMENT_OK, Stage::PAY);
                }
            } elseif ($acqStatus === BillingAcquiringStatus::HOLD) {
                if ($acqStatus !== $payment->getAcquiringStatus()) {
                    $this->getPaymentsRepository()->updateStatus(Payment::HOLD, $payment->getId());
                    $this->saveChatHistory($payment, PayStageMessages::HOLD, Stage::PAY);
                    $this->notifyClient($payment, PayStageMessages::HOLD, Stage::PAY);
                }
            }

            $this->updateBillingData($checkResponse, $payment);
        }
    }

    /**
     * @param CheckResponse $checkResponse
     * @param Payment $payment
     *
     * @throws \System\Exception\DiException
     */
    private function updateBillingData(CheckResponse $checkResponse, Payment $payment): void
    {
        $billingData = new BillingData(
            $checkResponse->getStatus(),
            $checkResponse->getChequeId(),
            $checkResponse->getPaymentId(),
            $checkResponse->getAcquiringStatus(),
            $checkResponse->getAcquiringConfirmUrl(),
            $checkResponse->getAcquiringTransactionId(),
            $checkResponse->getAcquiringMerchantId(),
            $checkResponse->getPsId(),
            $checkResponse->getOperatorPayId(),
            $checkResponse->getOperatorChequeId(),
            $payment->getId()
        );
        $this->getPaymentsRepository()->updateBillingData($billingData);
    }

    /**
     * @param Payment $payment
     *
     * @param int $subStage
     *
     * @param int $stage
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    private function notifyClient(Payment $payment, int $subStage, int $stage = Stage::CHECK): void
    {
        $chat = $this->getChatsRepository()->findByChequeId($payment->getChequeId());
        if ($chat->getChatBotId() === ChatBotId::TELEGRAM) {
            $message = new AnswerMessage($chat->getProviderChatId());
            $message->setMessage(
                $this->findCheckStageMessage($subStage, $chat, $payment, $stage)
            );
            $this->getPayBot()->sendUserMessage($message);
        }
    }

    /**
     * @param int $subStage
     * @param Chat $chat
     * @param Payment $payment
     * @param int $stage
     * @return string
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    private function findCheckStageMessage(int $subStage, Chat $chat, Payment $payment, int $stage): string
    {
        try {
            $stageMessage = $this->getStagesMessagesRepository()->findMessage(
                $stage,
                $subStage,
                $chat->getCurrentLocalization()
            );

            $stageMessageVariables = new StageMessageVariables();
            $stageMessageVariables->setTotalAmount($payment->getAmount()+$payment->getCommission());
            $stageMessageVariables->setAmount($payment->getAmount());
            $stageMessageVariables->setBillingChequeId($payment->getBillingChequeId());
            $stageMessageVariables->setCommission($payment->getCommission());

            return $this->getMessageProcessingComponent()->fillMessage($stageMessageVariables, $stageMessage);
        } catch (EmptyFetchResultException $e) {
            throw new DatabaseDataNotFoundException(
                'StageMessage not found for stage '.$stage.' subStage '.$subStage
            );
        }
    }

    /**
     * @param Payment $payment
     *
     * @param int $subStage
     * @param int $stage
     * @throws DiException
     */
    private function saveChatHistory(Payment $payment, int $subStage, int $stage = Stage::CHECK): void
    {
        try {
            if ($payment->getChatHistoryId() !== 0) {
                $createStageChatHistory = $this->getChatsHistoryRepository()->findById($payment->getChatHistoryId());
                $this->getChatsHistoryRepository()->create(new ChatHistory(
                    $createStageChatHistory->getId(),
                    $createStageChatHistory->getUserId(),
                    $stage,
                    $subStage,
                    $createStageChatHistory->getLocalization(),
                    date('Y-m-d H:i:s'),
                    $createStageChatHistory->getSessionGuid()
                ));
            }
        } catch (EmptyFetchResultException $e) {
            $this->getLogger()->debug('ChatHistory not found by id '.$payment->getChatHistoryId());
        }
    }
}
