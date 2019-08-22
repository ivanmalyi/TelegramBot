<?php

declare(strict_types=1);

namespace System\Facade\MainMenu;


use System\Component\PayBot\TGKeyboard;
use System\Entity\Component\Billing\LocalizationData;
use System\Entity\InternalProtocol\ButtonType;
use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\KeyboardValue;
use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\InternalProtocol\TGButtons;
use System\Entity\InternalProtocol\TGKeyboardAction;
use System\Entity\Repository\Button;
use System\Entity\Repository\Chat;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Facade\TelegramFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class MainMenuFacade
 * @package System\Facade\MainMenu
 */
class MainMenuFacade implements TelegramFacadeInterface
{
    use LoggerReferenceTrait;
    use MainMenuFacadeDependenciesTrait;
    use ChatHistoryTrait;

    /**
     * @param TelegramRequest $request
     *
     * @return AnswerMessage
     *
     * @throws DiException
     * @throws \Longman\TelegramBot\Exception\TelegramException
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function process(TelegramRequest $request): AnswerMessage
    {
        $chat = $this->saveInfoForInteraction($request);
        if (empty($chat->getPhone())) {
            return $this->redirectToSavePhoneStage($request);
        }

        $answerMessage = new AnswerMessage($request->getMessage()->getChat()->getId());

        if (
            !is_null($request->getCallbackData()) and
            $request->getCallbackData()->getTypeKeyboardAction() === TGKeyboardAction::GET_MENU_SERVICE
        ) {
            $button = $this->getButtonComponent()
                ->findButton($request->getCallbackData()->getButtonId(), $chat->getCurrentLocalization());
            $keyboardValues = $this->generateKeyboardValues($request, $chat, [$button]);
            $keyboard = TGKeyboard::keyboardWithCallbackData($keyboardValues);
        } else {
            $buttons = $this->getButtonComponent()
                ->findButtonsByType(ButtonType::MAIN_MENU_BUTTON, $chat->getCurrentLocalization());
            $keyboardValues = $this->generateKeyboardValues($request, $chat, $buttons);
            $keyboard = TGKeyboard::keyboardWithCallbackData($keyboardValues);
        }

        $answerMessage->setKeyboard($keyboard);
        $answerMessage->setMessage($this->getMessage($request, $chat));

        return $answerMessage;
    }

    /**
     * @param TelegramRequest $request
     * @return AnswerMessage
     */
    private function redirectToSavePhoneStage(TelegramRequest $request): AnswerMessage
    {
        $answerMessage = new AnswerMessage($request->getMessage()->getChat()->getId());
        $answerMessage->setGoToStage(Stage::SAVE_PHONE);

        return $answerMessage;
    }

    /**
     * @param TelegramRequest $telegramRequest
     *
     * @return Chat
     *
     * @throws DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function saveInfoForInteraction(TelegramRequest $telegramRequest): Chat
    {
        $chat = $this->getChatsRepository()->findByProviderChatId(
            $telegramRequest->getMessage()->getChat()->getId(),
            ChatBotId::TELEGRAM
        );

        $chat->setCurrentStage(Stage::MAIN_MENU);
        $chat->setCurrentSubStage(0);
        $chat->setCurrentLocalization($this->getLocalization($telegramRequest));

        $this->getChatsRepository()->updateCurrentInfo($chat);
        $this->saveHistoryByChat($chat);

        return $chat;
    }

    /**
     * @param TelegramRequest $telegramRequest
     *
     * @return string
     */
    private function getLocalization(TelegramRequest $telegramRequest): string
    {
        if ($telegramRequest->getMessage()->getFrom()->getLanguageCode() === 'uk') {
            return LocalizationData::UA;
        } elseif ($telegramRequest->getMessage()->getFrom()->getLanguageCode() === 'en') {
            return LocalizationData::EN;
        }
        return LocalizationData::RU;
    }

    /**
     * @param TelegramRequest $request
     * @param Chat $chat
     * @param Button[] $buttons
     *
     * @return KeyboardValue[]
     *
     * @throws DiException
     */
    private function generateKeyboardValues(TelegramRequest $request, Chat $chat, array $buttons): array
    {
        $keyboardValues= [];
        foreach ($buttons as $button) {
            $values = explode(';', $button->getValue());
            $countValues = count($values);

            if (!is_null($request->getCallbackData())) {
                foreach ($values as $value) {
                    try {
                        $itemLocalization = $this->getItemsLocalizationRepository()
                            ->findItemByIdAndLocale((int)$value, $chat->getCurrentLocalization());
                    } catch (EmptyFetchResultException $e) {
                        continue;
                    }
                    $keyboardValues[] = new KeyboardValue(
                        $itemLocalization->getName(),
                        $itemLocalization->getItemId(),
                        $button->getCallBackAction()
                    );
                }
            } else {
                $keyboardValues[] = new KeyboardValue(
                    $button->getName(),
                    $countValues > 1 ? $button->getId(): (int)$values[0],
                    $countValues > 1 ? TGKeyboardAction::GET_MENU_SERVICE: $button->getCallBackAction(),
                    $this->getButtonComponent()->findButton(TGButtons::PAGINATION_BACK, $chat->getCurrentLocalization())->getName(),
                    $this->getButtonComponent()->findButton(TGButtons::PAGINATION_FORWARD, $chat->getCurrentLocalization())->getName(),
                    TGKeyboardAction::GET_MENU_SERVICE
                );
            }
        }

        return $keyboardValues;
    }

    /**
     * @param TelegramRequest $telegramRequest
     * @param Chat $chat
     *
     * @return string
     *
     * @throws DiException
     */
    private function getMessage(TelegramRequest $telegramRequest, Chat $chat): string
    {
        try {
            $stageMessage = $this->getStagesMessagesRepository()->findMessage(
                $chat->getCurrentStage(),
                $chat->getCurrentSubStage(),
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
}