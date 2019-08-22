<?php

declare(strict_types=1);

namespace System\Facade\PrivateOffice;


use System\Component\PayBot\TGKeyboard;
use System\Entity\Component\Billing\LocalizationData;
use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\KeyboardValue;
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

/**
 * Class PrivateOfficeFacade
 * @package System\Facade\PrivateOffice
 */
class PrivateOfficeFacade implements TelegramFacadeInterface
{
    use LoggerReferenceTrait;
    use PrivateOfficeFacadeDependenciesTrait;
    use ChatHistoryTrait;

    /**
     * @param TelegramRequest $request
     *
     * @return AnswerMessage
     *
     * @throws \Longman\TelegramBot\Exception\TelegramException
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function process(TelegramRequest $request): AnswerMessage
    {
        $answerMessage = new AnswerMessage($request->getMessage()->getChat()->getId());
        $chat = $this->saveInfoForInteraction($request);

        if (empty($chat->getPhone())) {
            return $this->redirectToSavePhoneStage($request);
        }

        $answerMessage->setKeyboard($this->createPrivateOfficeKeyboard($request));
        $answerMessage->setMessage($this->getMessage($request, $chat));

        return $answerMessage;
    }

    /**
     * @param TelegramRequest $telegramRequest
     *
     * @return Chat
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function saveInfoForInteraction(TelegramRequest $telegramRequest): Chat
    {
        $chat = $this->getChatsRepository()->findByProviderChatId(
            $telegramRequest->getMessage()->getChat()->getId(),
            ChatBotId::TELEGRAM
        );

        $chat->setCurrentStage(Stage::PRIVATE_OFFICE);
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
     * @return \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup
     *
     * @throws \Longman\TelegramBot\Exception\TelegramException
     * @throws \System\Exception\DiException
     */
    private function createPrivateOfficeKeyboard(TelegramRequest $telegramRequest)
    {
        $localization = $this->getLocalization($telegramRequest);
        $privateOfficeMenu = [
            TGButtons::GET_CARD_LIST
        ];

        $keyboardValues = [];
        foreach ($privateOfficeMenu as $buttonId) {
            $button = $this->getButtonComponent()->findButton($buttonId, $localization);
            $keyboardValues[] = new KeyboardValue(
                $button->getName(),
                (int)$button->getValue(),
                $button->getCallBackAction()
            );
        }

        return TGKeyboard::keyboardWithCallbackData($keyboardValues);
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
}