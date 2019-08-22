<?php

declare(strict_types=1);

namespace System\Console\Service\Pay;

use System\Component\PayBot\TGKeyboard;
use System\Console\AbstractService;
use System\Entity\Component\Billing\BillingAcquiringStatus;
use System\Entity\Component\Billing\BillingResponseCode;
use System\Entity\Component\Billing\BillingResponseStatus;
use System\Entity\Component\Billing\Response\PayResponse;
use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\Repository\BillingData;
use System\Entity\Repository\Chat;
use System\Entity\Repository\ChatHistory;
use System\Entity\Repository\Payment;
use System\Entity\Repository\PaymentPrintData;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Exception\Protocol\DaemonNotActiveException;
use System\Exception\Protocol\DatabaseDataNotFoundException;
use System\Kernel\Protocol\AnswerMessage;
use System\Kernel\Protocol\CommandLinePacket;
use System\Util\ChatHistory\ChatHistoryTrait;

/**
 * Class PayService
 * @package System\Console\Service\Pay
 */
class PayService extends AbstractService
{
    use PayServiceDependenciesTrait;
    use ChatHistoryTrait;

    protected $sleep = 1 * 5;
    protected $serviceName = 'pay';

    /**
     * @param CommandLinePacket $packet
     * @return void
     *
     * @throws DaemonNotActiveException
     * @throws \System\Exception\DiException
     */
    protected function doService(CommandLinePacket $packet)
    {
        $this->checkForDaemonIsActive();

        $payments = $this->getPaymentsRepository()->findAllByStatuses([Payment::NEW]);
        foreach ($payments as $payment) {
            try {
                $this->getLogger()->info($payment->__toString(), [
                    'tag' => ['service', 'pay_service', 'request']
                ]);
                $payResponse = $this->getBillingComponent()->payByAcquiringOrder($payment);
                $this->getLogger()->info($payResponse->__toString(), [
                    'tag' => ['service', 'pay_service', 'response']
                ]);

                $this->processPayResponse($payResponse, $payment);
            } catch (\Throwable $e) {
                $this->getLogger()->error('PayService: '.$e->getMessage()."\nFile: ".$e->getFile().
                    '; Line: '.$e->getLine(),
                    ['tag' => ['service', 'pay_service', 'error']]
                );
            }
        }
    }

    /**
     * @param PayResponse $payResponse
     * @param Payment $payment
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    private function processPayResponse(PayResponse $payResponse, Payment $payment): void
    {
        if ($payResponse->getResult() === BillingResponseCode::SUCCESS_ACTION) {
            $this->updateBillingData($payResponse, $payment);
            $status = $payResponse->getStatus();
            $acqStatus = $payResponse->getAcquiringStatus();

            if ($status === BillingResponseStatus::WAITING and $acqStatus === BillingAcquiringStatus::SECURE_3D) {
                $this->getPaymentsRepository()->updateStatus(Payment::WAITING, $payment->getId());
                $this->send3dsUrl($payment, $payResponse);
            } elseif ($acqStatus === BillingAcquiringStatus::CANCEL) {
                $this->getPaymentsRepository()->updateStatus(Payment::CANCEL, $payment->getId());
                $this->notifyClient($payment, PayStageMessages::CANCEL);
            } elseif ($status === BillingResponseStatus::OK and $acqStatus === BillingAcquiringStatus::HOLD) {
                $this->getPaymentsRepository()->updateStatus(Payment::OK_PROVIDER_PAYMENT, $payment->getId());
                $this->notifyClient($payment, PayStageMessages::PAYMENT_OK);
            } elseif ($acqStatus === BillingAcquiringStatus::HOLD) {
                $this->getPaymentsRepository()->updateStatus(Payment::HOLD, $payment->getId());
                $this->notifyClient($payment, PayStageMessages::HOLD);
            } elseif ($acqStatus === BillingAcquiringStatus::WAITING) {
                $this->notifyClient($payment, PayStageMessages::WAITING);
                $this->getPaymentsRepository()->updateStatus(Payment::WAITING, $payment->getId());
            } else {
                $this->notifyClient($payment, PayStageMessages::PAYMENT_WAITING);
                $this->getPaymentsRepository()->updateStatus(Payment::WAITING, $payment->getId());
            }
        } else {
            $this->notifyClient($payment, PayStageMessages::WAITING);
            $this->getPaymentsRepository()->updateStatus(Payment::WAITING, $payment->getId());
        }
    }

    /**
     * @param PayResponse $payResponse
     * @param Payment $payment
     *
     * @throws DiException
     */
    private function updateBillingData(PayResponse $payResponse, Payment $payment): void
    {
        $billingData = new BillingData(
            $payResponse->getStatus(),
            $payResponse->getChequeId(),
            $payResponse->getPaymentId(),
            $payResponse->getAcquiringStatus(),
            $payResponse->getAcquiringConfirmUrl(),
            $payResponse->getAcquiringTransactionId(),
            $payResponse->getAcquiringMerchantId(),
            $payResponse->getPsId(),
            $payResponse->getOperatorPayId(),
            $payResponse->getOperatorChequeId(),
            $payment->getId()
        );
        $this->getPaymentsRepository()->updateBillingData($billingData);
        foreach ($payResponse->getPrint() as $print) {
            $this->getPaymentsPrintDataRepository()->create(new PaymentPrintData(
                $payment->getId(),
                $print->getText(),
                $print->getValue(),
                $print->getTarget()
            ));
        }
    }

    /**
     * @param Payment $payment
     * @param PayResponse $payResponse
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    private function send3dsUrl(Payment $payment, PayResponse $payResponse): void
    {
        $chat = $this->getChatsRepository()->findByChequeId($payment->getChequeId());
        if ($chat->getChatBotId() === ChatBotId::TELEGRAM) {
            $message = new AnswerMessage($chat->getProviderChatId());
            $message->setMessage(
                $this->findPayStageMessage(PayStageMessages::SECURE_3D, $chat, $payment)
            );
            $message->setKeyboard((new TGKeyboard())->link(
                '3D Secure',
                $payResponse->getAcquiringConfirmUrl()
            ));

            $this->getPayBot()->sendUserMessage($message);
        }
    }

    /**
     * @param Payment $payment
     *
     * @param int $subStage
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    private function notifyClient(Payment $payment, int $subStage): void
    {
        $chat = $this->getChatsRepository()->findByChequeId($payment->getChequeId());
        if ($chat->getChatBotId() === ChatBotId::TELEGRAM) {
            $message = new AnswerMessage($chat->getProviderChatId());
            $message->setMessage(
                $this->findPayStageMessage($subStage, $chat, $payment)
            );
            $this->getPayBot()->sendUserMessage($message);
        }
    }

    /**
     * @param int $subStage
     * @param Chat $chat
     * @param Payment $payment
     * @return string
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    private function findPayStageMessage(int $subStage, Chat $chat, Payment $payment): string
    {
        try {
            $stageMessage = $this->getStagesMessagesRepository()->findMessage(
                Stage::PAY,
                $subStage,
                $chat->getCurrentLocalization()
            );
            $this->saveChatHistory($payment, $subStage);

            $stageMessageVariables = new StageMessageVariables();
            $stageMessageVariables->setTotalAmount($payment->getAmount()+$payment->getCommission());
            $stageMessageVariables->setAmount($payment->getAmount());
            $stageMessageVariables->setBillingChequeId($payment->getBillingChequeId());
            $stageMessageVariables->setCommission($payment->getCommission());

            return $this->getMessageProcessingComponent()->fillMessage($stageMessageVariables, $stageMessage);
        } catch (EmptyFetchResultException $e) {
            throw new DatabaseDataNotFoundException(
                'StageMessage not found for stage '.Stage::PAY.' subStage '.$subStage
            );
        }
    }

    /**
     * @param int $subStage
     * @param Payment $payment
     *
     * @throws DiException
     */
    private function saveChatHistory(Payment $payment, int $subStage): void
    {
        try {
            if ($payment->getChatHistoryId() !== 0) {
                $createStageChatHistory = $this->getChatsHistoryRepository()->findById($payment->getChatHistoryId());
                $this->getChatsHistoryRepository()->create(new ChatHistory(
                    $createStageChatHistory->getId(),
                    $createStageChatHistory->getUserId(),
                    Stage::PAY,
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
