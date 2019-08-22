<?php

declare(strict_types=1);

namespace System\Facade\CardManagement;


use System\Component\PayBot\TGKeyboard;
use System\Entity\Component\Billing\BillingResponseCode;
use System\Entity\Component\Billing\LocalizationData;
use System\Entity\Component\Billing\Response\GetClientCardsResponse;
use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\InternalProtocol\TGButtons;
use System\Entity\InternalProtocol\TGKeyboardAction;
use System\Entity\Repository\Chat;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Facade\TelegramFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

/**
 * Class CardManagementFacade
 * @package System\Facade\CardManagement
 */
class CardManagementFacade implements TelegramFacadeInterface
{
    use LoggerReferenceTrait;
    use ChatHistoryTrait;
    use CardManagementDependenciesTrait;

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
        $answerMessage = new AnswerMessage($request->getMessage()->getChat()->getId());
        $chat = $this->saveInfoForInteraction($request);

        if ($request->getCallbackData()->getTypeKeyboardAction() === TGKeyboardAction::DELETE_CARD) {
            $response = $this->getBillingComponent()->unbindCardFromClient($request, $chat);
            if ($response->getResult() === BillingResponseCode::SUCCESS_ACTION) {
                $answerMessage->setIsUpdateKeyboard(true);
            }
        }
        $getClientCardsResponse = $this->getBillingComponent()->getClientCards($chat);

        if ($getClientCardsResponse->getResult() === BillingResponseCode::SUCCESS_ACTION and !empty($getClientCardsResponse->getUserCards())) {
            $keyboard = $this->createCardListKeyboard($getClientCardsResponse, $request);
            $answerMessage->setKeyboard($keyboard);
        } else {
            $chat->setCurrentSubStage(CardManagementFacadeSubStage::EMPTY_CARD_LIST);
        }

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

        $chat->setCurrentStage(Stage::CARD_MANAGEMENT);
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
     * @param GetClientCardsResponse $getClientCardsResponse
     * @param TelegramRequest $telegramRequest
     *
     * @return InlineKeyboardMarkup
     *
     * @throws DiException
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    private function createCardListKeyboard(
        GetClientCardsResponse $getClientCardsResponse,
        TelegramRequest $telegramRequest
    ): InlineKeyboardMarkup
    {
        $delButton = $this->getButtonComponent()
            ->findButton(TGButtons::DELETE_CARD, $this->getLocalization($telegramRequest));

        return TGKeyboard::cardListButtons($getClientCardsResponse->getUserCards(), $delButton);
    }
}