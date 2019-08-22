<?php

declare(strict_types=1);

namespace System\Facade\CalculateCommission;

use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\Currency;
use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\Repository\Chat;
use System\Entity\Repository\Cheque;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Exception\Protocol\DatabaseDataNotFoundException;
use System\Facade\TelegramFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class CalculateCommissionFacade
 * @package System\Facade\CalculateCommission
 */
class CalculateCommissionFacade implements TelegramFacadeInterface
{
    use LoggerReferenceTrait;
    use CalculateCommissionFacadeDependenciesTrait;
    use ChatHistoryTrait;

    /**
     * @param TelegramRequest $request
     * @return AnswerMessage
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    public function process(TelegramRequest $request): AnswerMessage
    {
        $answerMessage = new AnswerMessage($request->getMessage()->getChat()->getId());

        $chat = $this->saveInfoForInteraction($request);
        $cheque = $this->findCheque($chat);

        $cheque->setCommission(
            $this->calculateCommission($cheque)
        );
        $this->getChequesRepository()->updateCheque($cheque);

        $answerMessage->setMessage(
            $this->getMessageForCommissionInfo($chat, $cheque)
        );
        $answerMessage->setGoToStage(Stage::GET_PAYMENT_PAGE);
        return $answerMessage;
    }

    /**
     * @param TelegramRequest $telegramRequest
     *
     * @return Chat
     *
     * @throws DatabaseDataNotFoundException
     * @throws \System\Exception\DiException
     */
    private function saveInfoForInteraction(TelegramRequest $telegramRequest): Chat
    {
        try {
            $chat = $this->getChatsRepository()->findByProviderChatId(
                $telegramRequest->getMessage()->getChat()->getId(),
                ChatBotId::TELEGRAM
            );
        } catch (EmptyFetchResultException $e) {
            throw new DatabaseDataNotFoundException('Чат не найден');
        }

        $chat->setCurrentStage(Stage::CALCULATE_COMMISSION);
        $chat->setCurrentSubStage(0);
        $this->getChatsRepository()->updateCurrentInfo($chat);
        $this->saveHistoryByChat($chat);
        return $chat;
    }

    /**
     * @param Chat $chat
     *
     * @return Cheque
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    private function findCheque(Chat $chat): Cheque
    {
        try {
            $cheque = $this->getChequesRepository()->findById($chat->getCurrentChequeId());
            if ($cheque->getStatus() !== Cheque::OK) {
                throw new DatabaseDataNotFoundException(
                    'Cheque must have 21 status but '.$cheque->getStatus()
                );
            }
            return $cheque;
        } catch (EmptyFetchResultException $e) {
            throw new DatabaseDataNotFoundException('A cheque  '.$chat->getCurrentChequeId().' not found');
        }
    }

    /**
     * @param Cheque $cheque
     * @return int
     * @throws DiException
     */
    private function calculateCommission(Cheque $cheque): int
    {
        $commissions = $this->getCommissionsRepository()->findAllByChequeId($cheque->getId());

        foreach ($commissions as $commission) {
            if ($commission->getFromAmount() > $cheque->getAmount() or
                ($commission->getToAmount() !== 0 and $cheque->getAmount() > $commission->getToAmount())) {
                continue;
            }

            if ($commission->getAlgorithm() === 0) {
                $commissionAmount = $commission->getAmount();
            } else {
                $commissionAmount = (int) round((($commission->getAmount()/100)*$cheque->getAmount())/100);
                if ($commission->getRound() !== 0) {
                    $commissionAmount = (int) round($commissionAmount/$commission->getRound())*$commission->getRound();
                }

                if ($commissionAmount < $commission->getMinAmount()) {
                    $commissionAmount = $commission->getMinAmount();
                } elseif ($commission->getMaxAmount() !== 0 and $commissionAmount > $commission->getMaxAmount()) {
                    $commissionAmount = $commission->getMaxAmount();
                }
            }
            return $commissionAmount;
        }
        return 0;
    }

    /**
     * @param Chat $chat
     * @param Cheque $cheque
     *
     * @return string
     *
     * @throws DiException
     */
    private function getMessageForCommissionInfo(Chat $chat, Cheque $cheque): string
    {
        try {
            $stageMessage = $this->getStagesMessagesRepository()->findMessage(
                $chat->getCurrentStage(),
                0,
                $chat->getCurrentLocalization()
            );

            $stageMessageVariables = new StageMessageVariables();
            $stageMessageVariables->setCommission(Currency::kopeckToUah($cheque->getCommission()));

            return $this->getMessageProcessingComponent()->fillMessage($stageMessageVariables, $stageMessage);
        } catch (EmptyFetchResultException $e) {
            $this->getLogger()->debug('StageMessage not found for '.$chat->getCurrentStage());
            return 'Увы но я не знаю что сказать, обучи меня пожалуйста!';
        }
    }
}
