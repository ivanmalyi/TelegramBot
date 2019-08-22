<?php

declare(strict_types=1);

namespace System\Facade\GetOperators;

use System\Component\PayBot\TGKeyboard;
use System\Entity\Component\Billing\LocalizationData;
use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\KeyboardValue;
use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\InternalProtocol\TGButtons;
use System\Entity\InternalProtocol\TGKeyboardAction;
use System\Entity\Repository\Chat;
use System\Entity\Repository\ChequeCallbackUrl;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Facade\TelegramFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class GetOperatorsFacade
 * @package System\Facade\GetOperators
 */
class GetOperatorsFacade implements TelegramFacadeInterface
{
    use LoggerReferenceTrait;
    use GetOperatorsFacadeDependenciesTrait;
    use ChatHistoryTrait;

    /**
     * @param TelegramRequest $request
     *
     * @return AnswerMessage
     *
     * @throws DiException
     * @throws EmptyFetchResultException
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function process(TelegramRequest $request): AnswerMessage
    {
        $chat = $this->saveInfoForInteraction($request);
        $message = $this->getMessage($request, $chat);

        $answerMessage = new AnswerMessage(
            $request->getMessage()->getChat()->getId(),
            $request->getMessage()->getMessageId()
        );
        $answerMessage->setIsUpdateKeyboard(
            !is_null($request->getCallbackData()) ? $request->getCallbackData()->isPagination(): false
        );

        $keyboard = TGKeyboard::keyboardWithCallbackData(
            $this->generateKeyboardValues($request, $chat),
            $request->getCallbackData()
        );

        $answerMessage->setKeyboard($keyboard);
        $answerMessage->setMessage($message);
        return $answerMessage;
    }

    /**
     * @param TelegramRequest $telegramRequest
     * @return Chat
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function saveInfoForInteraction(TelegramRequest $telegramRequest): Chat
    {
        $chat = $this->getChatsRepository()->findByProviderChatId(
            $telegramRequest->getMessage()->getChat()->getId(),
            ChatBotId::TELEGRAM
        );

        if ($chat->getCurrentStage() === Stage::GET_PAYMENT_PAGE and in_array($chat->getCurrentSubStage(), [
                ChequeCallbackUrl::OK_CARD_DATA_INPUT, ChequeCallbackUrl::ERROR
            ])) {
            $chat->setCurrentSessionGuid(Chat::generateSessionGuid());
        }
        $chat->setCurrentStage(Stage::GET_OPERATORS);
        $chat->setCurrentSubStage(0);
        $chat->setCurrentLocalization($this->getLocalization($telegramRequest));
        $this->getChatsRepository()->updateCurrentInfo($chat);
        $this->saveHistoryByChat($chat);

        return $chat;
    }

    /**
     * @param TelegramRequest $telegramRequest
     * @param Chat $chat
     * @return string
     * @throws DiException
     */
    private function getMessage(TelegramRequest $telegramRequest, Chat $chat): string
    {
        try {
            $stageMessage = $this->getStagesMessagesRepository()->findMessage(
                $chat->getCurrentStage(),
                0,
                $chat->getCurrentLocalization()
            );

            $stageMessageVariables = new StageMessageVariables();
            $stageMessageVariables->setFio(
                $telegramRequest->getMessage()->getChat()->getFirstName() . ' ' .
                $telegramRequest->getMessage()->getChat()->getLastName()
            );

            return $this->getMessageProcessingComponent()->fillMessage($stageMessageVariables, $stageMessage);
        } catch (EmptyFetchResultException $e) {
            $this->getLogger()->debug('StageMessage not found for '.$chat->getCurrentStage());
            return 'Увы но я не знаю что сказать, обучи меня пожалуйста!';
        }
    }

    /**
     * @param TelegramRequest $telegramRequest
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
     * @param TelegramRequest $telegramRequest
     * @param Chat $chat
     *
     * @return KeyboardValue[]
     *
     * @throws DiException
     */
    private function generateKeyboardValues(TelegramRequest $telegramRequest, Chat $chat): array
    {
        $operatorsLocalization = $this->getOperatorsRepository()
            ->findOperatorsBySectionId(
                $telegramRequest->getCallbackData()->getButtonId(),
                $chat->getCurrentLocalization()
            );

        $keyboardValues= [];
        foreach ($operatorsLocalization as $operatorLocalization) {
            $keyboardValues[] = new KeyboardValue(
                $operatorLocalization->getName(),
                $operatorLocalization->getOperatorId(),
                TGKeyboardAction::GET_SERVICES,
                $this->getButtonComponent()->findButton(TGButtons::PAGINATION_BACK, $chat->getCurrentLocalization())->getName(),
                $this->getButtonComponent()->findButton(TGButtons::PAGINATION_FORWARD, $chat->getCurrentLocalization())->getName(),
                TGKeyboardAction::GET_OPERATORS
            );
        }

        return $keyboardValues;
    }
}