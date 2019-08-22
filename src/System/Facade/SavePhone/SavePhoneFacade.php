<?php

declare(strict_types=1);

namespace System\Facade\SavePhone;


use System\Component\PayBot\TGKeyboard;
use System\Entity\Component\Billing\LocalizationData;
use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\InternalProtocol\TGButtons;
use System\Entity\Repository\Chat;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Facade\TelegramFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

/**
 * Class SavePhoneFacade
 * @package System\Facade\SavePhone
 */
class SavePhoneFacade implements TelegramFacadeInterface
{
    use LoggerReferenceTrait;
    use SavePhoneFacadeDependenciesTrait;
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

        $answerMessage = new AnswerMessage($request->getMessage()->getChat()->getId());
        $message = $this->getMessage($request, $chat);
        $answerMessage->setMessage($message);

        if ($chat->getCurrentSubStage() === SavePhoneFacadeSubStage::NUMBER_SAVED) {
            $answerMessage->setKeyboard($this->createNavigationKeyboard($request));
        } else {
            $answerMessage->setKeyboard($this->createShowPhoneButton($request));
        }

        return $answerMessage;
    }

    /**
     * @param TelegramRequest $telegramRequest
     * @return Chat
     * @throws DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function saveInfoForInteraction(TelegramRequest $telegramRequest): Chat
    {
        $chat = $this->getChatsRepository()->findByProviderChatId(
            $telegramRequest->getMessage()->getChat()->getId(),
            ChatBotId::TELEGRAM
        );
        $this->updateUserInfo($telegramRequest, $chat);

        if ($chat->getCurrentStage() === Stage::SAVE_PHONE or !is_null($telegramRequest->getMessage()->getContact())) {
            $chat->setCurrentSubStage(SavePhoneFacadeSubStage::NUMBER_SAVED);
            $chat->setPhone(ltrim($telegramRequest->getMessage()->getContact()->getPhoneNumber(), '+'));
        } else {
            $chat->setCurrentSubStage(SavePhoneFacadeSubStage::DEFAULT);
        }

        $chat->setCurrentStage(Stage::SAVE_PHONE);
        $chat->setCurrentLocalization($this->getLocalization($telegramRequest));
        $this->getChatsRepository()->updateCurrentInfo($chat);
        $this->saveHistoryByChat($chat);

        return $chat;
    }

    /**
     * @param TelegramRequest $telegramRequest
     * @param Chat $chat
     *
     * @throws DiException
     */
    private function updateUserInfo(TelegramRequest $telegramRequest, Chat $chat): void
    {
        $this->getUsersRepository()->updateUserInfo(
            $telegramRequest->getMessage()->getChat()->getFirstName(),
            $telegramRequest->getMessage()->getChat()->getLastName(),
            $chat->getUserId()
        );
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

    /**
     * @param TelegramRequest $telegramRequest
     *
     * @return ReplyKeyboardMarkup
     *
     * @throws DiException
     * @throws EmptyFetchResultException
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    private function createNavigationKeyboard(TelegramRequest $telegramRequest): ReplyKeyboardMarkup
    {
        $localization = $this->getLocalization($telegramRequest);

        $menuButton = ($this->getButtonComponent()->findButton(TGButtons::MENU, $localization))->getName();
        $searchButton = ($this->getButtonComponent()->findButton(TGButtons::SEARCH, $localization))->getName();
        $updatePhoneButton = ($this->getButtonComponent()->findButton(TGButtons::UPDATE_NUMBER, $localization))->getName();
        $privateOfficeButton = ($this->getButtonComponent()->findButton(TGButtons::PRIVATE_OFFICE, $localization))->getName();

        return TGKeyboard::navigationButtons($menuButton, $searchButton, $updatePhoneButton, $privateOfficeButton);
    }

    /**
     * @param TelegramRequest $telegramRequest
     *
     * @return ReplyKeyboardMarkup
     *
     * @throws DiException
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    private function createShowPhoneButton(TelegramRequest $telegramRequest): ReplyKeyboardMarkup
    {
        $localization = $this->getLocalization($telegramRequest);

        $showPhoneButton = ($this->getButtonComponent()->findButton(TGButtons::SHOW_NUMBER, $localization))->getName();

        return TGKeyboard::contactButtons($showPhoneButton);
    }
}