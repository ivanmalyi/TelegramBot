<?php

declare(strict_types=1);

namespace System\Facade\LoadAmount;

use System\Entity\Component\Billing\LocalizationData;
use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\Currency;
use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\Repository\Chat;
use System\Entity\Repository\Cheque;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Exception\Protocol\BadItemAmountException;
use System\Exception\Protocol\DatabaseDataNotFoundException;
use System\Facade\TelegramFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class LoadAmountFacade
 * @package System\Facade\LoadAmount
 */
class LoadAmountFacade implements TelegramFacadeInterface
{
    use LoggerReferenceTrait;
    use LoadAmountFacadeDependenciesTrait;
    use ChatHistoryTrait;

    /**
     * @param TelegramRequest $request
     *
     * @return AnswerMessage
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    public function process(TelegramRequest $request): AnswerMessage
    {
        $answerMessage = new AnswerMessage($request->getMessage()->getChat()->getId());

        $chat = $this->saveInfoForInteraction($request);

        $message = '';
        if ($chat->getCurrentSubStage() === LoadAmountFacadeSubStage::DEFAULT or
            $chat->getCurrentSubStage() >= LoadAmountFacadeSubStage::CHEQUE_IS_CORRECT) {

            $message = $this->getMessage($request, $chat);
        } elseif ($chat->getCurrentSubStage() === LoadAmountFacadeSubStage::MESSAGE_FOUND) {
            try {
                $this->saveAmount($request, $chat);
                $answerMessage->setGoToStage(Stage::CALCULATE_COMMISSION);
            } catch (BadItemAmountException $e) {
                $message = $this->getMessageBySubStage($request, $chat, $e->getCode(), $e->getMessage());
                $answerMessage->setGoToStage(Stage::GET_AMOUNT);
                $this->checkAttempts($chat, $answerMessage);
            }
        }

        $answerMessage->setMessage($message);
        $chat->setAttempts(-1);
        $this->checkAttempts($chat, $answerMessage);

        return $answerMessage;
    }

    /**
     * @param TelegramRequest $telegramRequest
     *
     * @return Chat
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
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

        if ($chat->getCurrentStage() !== Stage::GET_AMOUNT) {
            $chat->setCurrentStage(Stage::GET_AMOUNT);
            $chat->setCurrentSubStage(LoadAmountFacadeSubStage::DEFAULT);
            $chat->setCurrentLocalization($this->getLocalization($telegramRequest));
            $this->getChatsRepository()->updateCurrentInfo($chat);
        }
        $this->saveHistoryByChat($chat);

        return $chat;
    }

    /**
     * @param TelegramRequest $telegramRequest
     * @param Chat $chat
     *
     * @return string
     *
     * @throws \System\Exception\DiException
     */
    private function getMessage(TelegramRequest $telegramRequest, Chat $chat): string
    {
        try {
            $stageMessage = $this->getStagesMessagesRepository()->findMessage(
                $chat->getCurrentStage(),
                LoadAmountFacadeSubStage::DEFAULT,
                $chat->getCurrentLocalization()
            );

            $chat->setCurrentSubStage(LoadAmountFacadeSubStage::MESSAGE_FOUND);
            $this->getChatsRepository()->updateCurrentStages($chat);

            $stageMessageVariables = new StageMessageVariables();
            $stageMessageVariables->setFio($telegramRequest->getMessage()->getChat()->getFirstName());

            return $this->getMessageProcessingComponent()->fillMessage($stageMessageVariables, $stageMessage);
        } catch (EmptyFetchResultException $e) {
            $this->getLogger()->debug('StageMessage not found for '.$chat->getCurrentStage());
            return 'Увы но я не знаю что сказать, обучи меня пожалуйста!';
        }
    }

    /**
     * @param TelegramRequest $request
     * @param Chat $chat
     * @param int $subStage
     *
     * @param string $amount
     * @return string
     *
     * @throws DiException
     */
    private function getMessageBySubStage(TelegramRequest $request, Chat $chat, int $subStage, string $amount): string
    {
        try {
            $stageMessage = $this->getStagesMessagesRepository()->findMessage(
                $chat->getCurrentStage(),
                $subStage,
                $chat->getCurrentLocalization()
            );

            $stageMessageVariables = new StageMessageVariables();
            $stageMessageVariables->setAmount((float) $amount);
            $stageMessageVariables->setFio($request->getMessage()->getChat()->getFirstName());


            return $this->getMessageProcessingComponent()->fillMessage($stageMessageVariables, $stageMessage);
        } catch (EmptyFetchResultException $e) {
            $this->getLogger()->debug('StageMessage not found for '.$chat->getCurrentStage());
            return 'Увы но я не знаю что сказать, обучи меня пожалуйста!';
        }
    }

    /**
     * @param TelegramRequest $telegramRequest
     *
     * @return string
     */
    private function getLocalization(TelegramRequest $telegramRequest): string
    {
        try {
            if ($telegramRequest->getMessage()->getFrom()->getLanguageCode() === 'uk') {
                return LocalizationData::UA;
            } elseif ($telegramRequest->getMessage()->getFrom()->getLanguageCode() === 'en') {
                return LocalizationData::EN;
            }
        } catch (\Throwable $e) {
        }
        return LocalizationData::RU;
    }

    /**
     * @param TelegramRequest $request
     * @param Chat $chat
     *
     * @return void
     *
     * @throws BadItemAmountException
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    private function saveAmount(TelegramRequest $request, Chat $chat): void
    {
        try {
            $cheque = $this->getChequesRepository()->findById($chat->getCurrentChequeId());
            if ($cheque->getStatus() !== Cheque::OK) {
                throw new DatabaseDataNotFoundException(
                    'Cheque must have 0 status but '.$cheque->getStatus()
                );
            }
        } catch (EmptyFetchResultException $e) {
            throw new DatabaseDataNotFoundException('A cheque  '.$chat->getCurrentChequeId().' not found');
        }

        $chat->setCurrentSubStage(LoadAmountFacadeSubStage::CHEQUE_IS_CORRECT);
        $this->getChatsRepository()->updateCurrentInfo($chat);

        $amount = $this->validateAmount($request, $cheque);

        $cheque->setAmount($amount);
        $this->getChequesRepository()->updateCheque($cheque);
    }

    /**
     * @param TelegramRequest $request
     * @param Cheque $cheque
     *
     * @return int
     *
     * @throws BadItemAmountException
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    private function validateAmount(TelegramRequest $request, Cheque $cheque): int
    {
        $amount = str_replace(',', '.', $request->getMessage()->getText());
        if (!is_numeric($amount)) {
            throw new BadItemAmountException(0,LoadAmountFacadeSubStage::INVALID_AMOUNT);
        }
        $amount = Currency::uahToKopeck((float) $amount);

        try {
            $display = $this->getDisplayRepository()->findDisplayByChequeId($cheque->getId());
            $minAmount = $display->getBillingMinPayAmount();
            $maxAmount = $display->getBillingMaxPayAmount();
        } catch (EmptyFetchResultException $e) {
            $minAmount = 0;
            $maxAmount = 0;
        }

        try {
            $item = $this->getItemsRepository()->findById($cheque->getItemId());
        } catch (EmptyFetchResultException $e) {
            throw new DatabaseDataNotFoundException('Item not found');
        }

        if (($minAmount !== 0 and $minAmount > $amount) or ($item->getMinAmount() > $amount)) {
            throw new BadItemAmountException(
                $minAmount !== 0 ? Currency::kopeckToUah($minAmount): Currency::kopeckToUah($item->getMinAmount()),
                LoadAmountFacadeSubStage::LITTLE_AMOUNT
            );
        } elseif (($maxAmount !== 0 and $maxAmount < $amount) or ($item->getMaxAmount() < $amount)) {
            throw new BadItemAmountException(
                $maxAmount !== 0 ? Currency::kopeckToUah($maxAmount): Currency::kopeckToUah($item->getMaxAmount()),
                LoadAmountFacadeSubStage::LARGE_AMOUNT
            );
        }

        return $amount;
    }

    /**
     * @param Chat $chat
     * @param AnswerMessage $answerMessage
     *
     * @throws DiException
     */
    private function checkAttempts(Chat $chat, AnswerMessage $answerMessage): void
    {
        $attempts = $chat->getAttempts();
        if ($attempts > 1) {
            $chat->setAttempts(0);
            $this->getChatsRepository()->updateAttempts($chat);
            $answerMessage->setGoToStage(Stage::MAIN_MENU);
        } else {
            $chat->setAttempts($attempts + 1);
            $this->getChatsRepository()->updateAttempts($chat);
        }
    }
}
