<?php

declare(strict_types=1);

namespace System\Facade\GetSections;

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
 * Class GetSectionsFacade
 * @package System\Facade\GetSections
 */
class GetSectionsFacade implements TelegramFacadeInterface
{
    use LoggerReferenceTrait;
    use GetSectionsFacadeDependenciesTrait;
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
        if (empty($chat->getPhone())) {
            return $this->redirectToSavePhoneStage($request);
        }
        $message = $this->getMessage($request, $chat);

        $answerMessage = new AnswerMessage(
            $request->getMessage()->getChat()->getId(),
            $request->getMessage()->getMessageId()
        );

        $answerMessage->setIsUpdateKeyboard(
            !is_null($request->getCallbackData()) ? $request->getCallbackData()->isPagination(): false
        );

        $keyboard = TGKeyboard::keyboardWithCallbackData(
            $this->generateKeyboardValues($this->getLocalization($request)),
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
        $this->updateUserInfo($telegramRequest, $chat);

        if ($chat->getCurrentStage() === Stage::GET_PAYMENT_PAGE and in_array($chat->getCurrentSubStage(), [
                ChequeCallbackUrl::OK_CARD_DATA_INPUT, ChequeCallbackUrl::ERROR
            ])) {
            $chat->setCurrentSessionGuid(Chat::generateSessionGuid());
        }
        $chat->setCurrentStage(Stage::GET_SECTIONS);
        $chat->setCurrentSubStage(0);
        $chat->setCurrentLocalization($this->getLocalization($telegramRequest));
        $this->getChatsRepository()->updateCurrentInfo($chat);
        $this->saveHistoryByChat($chat);

        return $chat;
    }

    /**
     * @param string $localization
     *
     * @return array
     *
     * @throws DiException
     */
    private function generateKeyboardValues(string $localization): array
    {
        $sections = $this->getSectionsRepository()->findAllSections();

        $keyboardValues= [];
        foreach ($sections as $section) {
            switch ($localization) {
                case LocalizationData::RU:
                    $nameSection = $section->getNameRu();

                    break;
                case LocalizationData::UA:
                    $nameSection = $section->getNameUa();

                    break;
                case LocalizationData::EN:
                    $nameSection = $section->getNameEn();

                    break;
            }

            $keyboardValues[] = new KeyboardValue(
                empty($nameSection) ? $section->getNameRu(): $nameSection,
                $section->getId(),
                TGKeyboardAction::GET_OPERATORS,
                $this->getButtonComponent()->findButton(TGButtons::PAGINATION_BACK, $localization)->getName(),
                $this->getButtonComponent()->findButton(TGButtons::PAGINATION_FORWARD, $localization)->getName(),
                TGKeyboardAction::GET_SECTIONS
            );

        }

        return $keyboardValues;
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
        if ($telegramRequest->getMessage()->getFrom()->getLanguageCode() === 'uk') {
            return LocalizationData::UA;
        } elseif ($telegramRequest->getMessage()->getFrom()->getLanguageCode() === 'en') {
            return LocalizationData::EN;
        }
        return LocalizationData::RU;
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
     * @param TelegramRequest $request
     * @return AnswerMessage
     */
    private function redirectToSavePhoneStage(TelegramRequest $request): AnswerMessage
    {
        $answerMessage = new AnswerMessage($request->getMessage()->getChat()->getId());
        $answerMessage->setGoToStage(Stage::SAVE_PHONE);

        return $answerMessage;
    }

}