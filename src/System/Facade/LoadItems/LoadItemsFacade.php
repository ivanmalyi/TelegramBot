<?php

declare(strict_types=1);

namespace System\Facade\LoadItems;

use System\Component\PayBot\TGKeyboard;
use System\Entity\Component\Billing\LocalizationData;
use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\KeyboardValue;
use System\Entity\InternalProtocol\Request\Telegram\CallbackData;
use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\InternalProtocol\TGButtons;
use System\Entity\InternalProtocol\TGKeyboardAction;
use System\Entity\Repository\Chat;
use System\Entity\Repository\ChequeCallbackUrl;
use System\Entity\Repository\ItemWithLocalization;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Facade\TelegramFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class LoadItemsFacade
 * @package System\Facade\LoadItems
 */
class LoadItemsFacade implements TelegramFacadeInterface
{
    use LoggerReferenceTrait;
    use LoadItemsFacadeDependenciesTrait;
    use ChatHistoryTrait;

    /**
     * @param TelegramRequest $request
     * @return AnswerMessage
     * @throws DiException
     * @throws EmptyFetchResultException
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function process(TelegramRequest $request): AnswerMessage
    {
        $chat = $this->saveInfoForInteraction($request);
        $message = $this->getMessage($chat);

        $answerMessage = new AnswerMessage(
            $request->getMessage()->getChat()->getId(),
            $request->getMessage()->getMessageId()
        );

        $itemsWithLocalization = $this->getItemsRepository()->findItemsByServiceId(
                $request->getCallbackData()->getButtonId(),
                $chat->getCurrentLocalization()
            );

        if (count($itemsWithLocalization) === 1) {
            return $this->redirectToGetItemInputFieldsStage($itemsWithLocalization, $request);
        }

        $answerMessage->setIsUpdateKeyboard(
            !is_null($request->getCallbackData()) ? $request->getCallbackData()->isPagination(): false
        );
        $keyboard = TGKeyboard::keyboardWithCallbackData(
            $this->generateKeyboardValues($itemsWithLocalization, $chat),
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
        $chat->setCurrentStage(Stage::GET_ITEMS);
        $chat->setCurrentSubStage(0);
        $chat->setCurrentLocalization($this->getLocalization($telegramRequest));
        $this->getChatsRepository()->updateCurrentInfo($chat);
        $this->saveHistoryByChat($chat);

        return $chat;
    }

    /**
     * @param Chat $chat
     * @return string
     * @throws DiException
     */
    private function getMessage(Chat $chat): string
    {
        try {
            $stageMessage = $this->getStagesMessagesRepository()->findMessage(
                $chat->getCurrentStage(),
                0,
                $chat->getCurrentLocalization()
            );

            return $this->getMessageProcessingComponent()->fillMessage(new StageMessageVariables(), $stageMessage);
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
     * @param ItemWithLocalization[] $itemsWithLocalization
     * @param TelegramRequest $request
     * @return AnswerMessage
     */
    private function redirectToGetItemInputFieldsStage(array $itemsWithLocalization, TelegramRequest $request): AnswerMessage
    {
        $answerMessage = new AnswerMessage($request->getMessage()->getChat()->getId());
        $answerMessage->setGoToStage(Stage::GET_ITEM_INPUT_FIELDS);
        $answerMessage->setCallbackData(new CallbackData(
            TGKeyboardAction::GET_ITEM_INPUT_FIELDS,
            $itemsWithLocalization[0]->getId(),
            false,
            0,
            '',
            ''
        ));
        return $answerMessage;
    }


    /**
     * @param ItemWithLocalization[] $itemsWithLocalization
     * @param Chat $chat
     *
     * @return KeyboardValue[]
     *
     * @throws DiException
     */
    private function generateKeyboardValues(array $itemsWithLocalization, Chat $chat): array
    {
        $keyboardValues= [];
        foreach ($itemsWithLocalization as $itemWithLocalization) {
            $keyboardValues[] = new KeyboardValue(
                $itemWithLocalization->getName(),
                $itemWithLocalization->getId(),
                TGKeyboardAction::GET_ITEM_INPUT_FIELDS,
                $this->getButtonComponent()->findButton(TGButtons::PAGINATION_BACK, $chat->getCurrentLocalization())->getName(),
                $this->getButtonComponent()->findButton(TGButtons::PAGINATION_FORWARD, $chat->getCurrentLocalization())->getName(),
                TGKeyboardAction::GET_ITEMS
            );
        }

        return $keyboardValues;
    }
}