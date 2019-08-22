<?php

declare(strict_types=1);

namespace System\Console\Service\Cheque;


use System\Console\AbstractService;
use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\Repository\Chat;
use System\Entity\Repository\ChatHistory;
use System\Entity\Repository\Payment;
use System\Entity\Repository\StageMessage;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Kernel\Protocol\AnswerMessage;
use System\Kernel\Protocol\CommandLinePacket;
use System\Util\ChatHistory\ChatHistoryTrait;

/**
 * Class ChequeService
 * @package System\Console\Service\Cheque
 */
class ChequeService extends AbstractService
{
    use ChequeServiceDependenciesTrait;
    use ChatHistoryTrait;

    /**
     * @var int
     */
    protected $sleep = 1 * 10;
    /**
     * @var string
     */
    protected $serviceName = 'cheque';

    /**
     * @param CommandLinePacket $packet
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\Protocol\DaemonNotActiveException
     */
    protected function doService(CommandLinePacket $packet)
    {
        $this->checkForDaemonIsActive();

        try {
            $payments = $this->getPaymentsRepository()->findAllByStatuses([Payment::COMPLETE]);

            if (!empty($payments)) {
                foreach ($payments as $payment) {
                    $chat = $this->getChatsRepository()->findByChequeId($payment->getChequeId());
                    $chat->setCurrentStage(Stage::CHEQUE);
                    $chat->setCurrentSubStage(ChequeSubStage::WISH);
                    $createChequeComponent = $this->getCreateChequeComponent()->generateCheque($payment);

                    if ($chat->getChatBotId() === ChatBotId::TELEGRAM) {
                        $answerMessage = new AnswerMessage($chat->getProviderChatId());
                        $answerMessage->setPictureUrl($createChequeComponent->getChequeUrl());
                        $this->getPayBot()->sendPicture($answerMessage);

                        $message = $this->getMessageProcessingComponent()
                            ->fillMessage(new StageMessageVariables(), $this->getMessage($chat));
                        $answerMessage->setMessage($message);

                        usleep(500000);
                        $this->getPayBot()->sendUserMessage($answerMessage);
                    }

                    $this->getChequesTextRepository()->saveChequeText($createChequeComponent->getChequeText(), $payment->getChequeId());
                    $this->getLogger()->info($createChequeComponent->getChequeText(), ['tag' => ['service', 'cheque_service']]);
                    $this->getPaymentsRepository()->updateStatus(Payment::CHEQUE_ISSUED, $payment->getId());
                    $this->deleteCheque($createChequeComponent->getChequeName());
                    $this->saveChatHistory($payment, 0);
                }
            }
        } catch (\Throwable $t) {
            $this->getLogger()->error('ChequeService: '.$t->getMessage()."\nFile: ".$t->getFile().
                "\n Line: ".$t->getLine() . "\nErrorCode: ".$t->getCode(),
                ['tag' => ['service', 'cheque_service', 'error']]
            );
        }
    }

    /**
     * @param string $chequeName
     */
    private function deleteCheque(string $chequeName): void
    {
        unlink( __DIR__ . '/../../../../../public/' . $chequeName);
    }

    /**
     * @param Payment $payment
     *
     * @param int $subStage
     * @param int $stage
     * @throws DiException
     */
    private function saveChatHistory(Payment $payment, int $subStage, int $stage = Stage::CHEQUE): void
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

    /**
     * @param Chat $chat
     *
     * @return StageMessage
     *
     * @throws DiException
     */
    private function getMessage(Chat $chat): StageMessage
    {
        try {
            $stageMessage = $this->getStagesMessagesRepository()->findMessage(
                $chat->getCurrentStage(),
                $chat->getCurrentSubStage(),
                $chat->getCurrentLocalization()
            );

            return $stageMessage;
        } catch (EmptyFetchResultException $e) {
            $this->getLogger()->debug('StageMessage not found for ' . $chat->getCurrentStage());
            return  new StageMessage(
                $chat->getCurrentStage(),
                $chat->getCurrentSubStage(),
                $chat->getCurrentLocalization(),
                'Увы но я не знаю что сказать, обучи меня пожалуйста!',
                0
            );

        }
    }
}