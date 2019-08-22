<?php

declare(strict_types=1);

namespace System\Facade\Start;

use System\Component\PayBot\TGKeyboard;
use System\Entity\Component\Billing\LocalizationData;
use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\InternalProtocol\TGButtons;
use System\Entity\Repository\Chat;
use System\Entity\Repository\User;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Facade\TelegramFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

/**
 * Class VerifyFacade
 * @package System\Facade\Verify
 */
class StartFacade implements TelegramFacadeInterface
{
    use LoggerReferenceTrait;
    use StartFacadeDependenciesTrait;
    use ChatHistoryTrait;

    /**
     * @param TelegramRequest $request
     *
     * @return AnswerMessage
     *
     * @throws DiException
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function process(TelegramRequest $request): AnswerMessage
    {
        $chat = $this->saveInfoForInteraction($request);

        $startParams = explode(' ', trim($request->getMessage()->getText()));
        if (count($startParams) > 1) {
            try {
                $this->bindGuidToUser($startParams, $chat);
            } catch (EmptyFetchResultException $e) {
                $this->getLogger()->debug(
                    "BindGuidToUser error: " . $e->getMessage(), ['tag' => ['utm_error', 'start']]
                );
            }
        }

        if (empty($chat->getPhone())) {
            return $this->redirectToSavePhoneStage($request);
        }
        $message = $this->getMessage($request, $chat);

        $answerMessage = new AnswerMessage($request->getMessage()->getChat()->getId());

        $answerMessage->setKeyboard($this->createNavigationKeyboard($request));
        $answerMessage->setMessage($message);
        return $answerMessage;
    }

    /**
     * @param TelegramRequest $telegramRequest
     *
     * @return Chat
     *
     * @throws DiException
     */
    private function saveInfoForInteraction(TelegramRequest $telegramRequest): Chat
    {
        try {
            $chat = $this->getChatsRepository()->findByProviderChatId(
                $telegramRequest->getMessage()->getChat()->getId(),
                ChatBotId::TELEGRAM
            );

            $chat->setCurrentStage(Stage::START);
            $chat->setCurrentSubStage(0);
            $chat->setCurrentLocalization($this->getLocalization($telegramRequest));
            $chat->setCurrentSessionGuid(Chat::generateSessionGuid());

            $this->getChatsRepository()->updateCurrentInfo($chat);
            $this->saveHistoryByChat($chat);

            $this->updateUserInfo($telegramRequest, $chat);
        } catch (EmptyFetchResultException $e) {
            $chat = new Chat(
                $this->getUsersRepository()->create(User::buildFromTelegramRequest($telegramRequest)),
                Stage::NEW_USER,
                0,
                0,
                $this->getLocalization($telegramRequest),
                $telegramRequest->getMessage()->getChat()->getId(),
                ChatBotId::TELEGRAM,
                Chat::generateSessionGuid()
            );
            $chatId = $this->getChatsRepository()->create($chat);
            $chat->setId($chatId);
            $this->saveHistoryByChat($chat);
        }

        return $chat;
    }

    /**
     * @param array $startParams
     * @param Chat $chat
     *
     * @return int
     *
     * @throws DiException
     * @throws EmptyFetchResultException
     */
    private function bindGuidToUser(array $startParams, Chat $chat): int
    {
        $giud = $startParams[1];

        $userAd = $this->getUserAdsRepository()->findByGuidUser($giud);

        return $this->getUserAdsRepository()->updateUserId($userAd->getId(), $chat->getUserId());
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
     * @return ReplyKeyboardMarkup
     *
     * @throws DiException
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
}
