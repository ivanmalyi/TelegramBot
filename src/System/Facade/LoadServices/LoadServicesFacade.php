<?php

declare(strict_types=1);

namespace System\Facade\LoadServices;

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
use System\Entity\Repository\Service;
use System\Exception\EmptyFetchResultException;
use System\Facade\TelegramFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class GetServicesFacade
 * @package System\Facade\GetServices
 */
class LoadServicesFacade implements TelegramFacadeInterface
{
    use LoggerReferenceTrait;
    use LoadServicesFacadeDependenciesTrait;
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
        $chat = $this->saveInfoForInteraction($request);
        $message = $this->getMessage($request, $chat);

        $answerMessage = new AnswerMessage(
            $request->getMessage()->getChat()->getId(),
            $request->getMessage()->getMessageId()
        );

        $services = $this->getServicesRepository()->findAllByOperatorId($request->getCallbackData()->getButtonId());
        if (count($services) === 1) {
            return $this->redirectToGetItemsStage($services, $request);
        }

        $answerMessage->setIsUpdateKeyboard(
            !is_null($request->getCallbackData()) ? $request->getCallbackData()->isPagination(): false
        );
        $keyboard = TGKeyboard::keyboardWithCallbackData(
            $this->generateKeyboardValues($services, $chat),
            $request->getCallbackData()
        );

        $answerMessage->setKeyboard($keyboard);
        $answerMessage->setMessage($message);
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

        if ($chat->getCurrentStage() === Stage::GET_PAYMENT_PAGE and in_array($chat->getCurrentSubStage(), [
                ChequeCallbackUrl::OK_CARD_DATA_INPUT, ChequeCallbackUrl::ERROR
            ])) {
            $chat->setCurrentSessionGuid(Chat::generateSessionGuid());
        }
        $chat->setCurrentStage(Stage::GET_SERVICES);
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
     *
     * @throws \System\Exception\DiException
     */
    private function getMessage(TelegramRequest $telegramRequest, Chat $chat): string
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
        } catch (\Throwable $e) {}

        return LocalizationData::RU;
    }

    /**
     * @param array $services
     * @param TelegramRequest $request
     * @return AnswerMessage
     */
    private function redirectToGetItemsStage(array $services, TelegramRequest $request): AnswerMessage
    {
        $answerMessage = new AnswerMessage(
            $request->getMessage()->getChat()->getId(),
            $request->getMessage()->getMessageId()
        );
        $answerMessage->setGoToStage(Stage::GET_ITEMS);
        $answerMessage->setCallbackData(new CallbackData(
            TGKeyboardAction::GET_ITEMS,
            $services[0]->getId(),
            false,
            0,
            '',
            ''
        ));
        return $answerMessage;
    }

    /**
     * @param Service[] $services
     *
     * @param Chat $chat
     * @return array
     *
     * @throws \System\Exception\DiException
     */
    private function generateKeyboardValues(array $services, Chat $chat): array
    {
        $keyboardValues= [];
        foreach ($services as $service) {
            try {
                $localization = $this->getServicesLocalizationRepository()->findByServiceIdAndLocalization(
                    $service->getId(),
                    $chat->getCurrentLocalization()
                );
            } catch (EmptyFetchResultException $e) {
                continue;
            }

            $keyboardValues[] = new KeyboardValue(
                $localization->getName(),
                $service->getId(),
                TGKeyboardAction::GET_ITEMS,
                $this->getButtonComponent()->findButton(TGButtons::PAGINATION_BACK, $chat->getCurrentLocalization())->getName(),
                $this->getButtonComponent()->findButton(TGButtons::PAGINATION_FORWARD, $chat->getCurrentLocalization())->getName(),
                TGKeyboardAction::GET_SERVICES
            );
        }

        return $keyboardValues;
    }
}
