<?php

declare(strict_types=1);

namespace System\Facade\Search;


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
use System\Entity\Repository\Chat;
use System\Entity\Repository\ChequeCallbackUrl;
use System\Entity\Repository\ItemLocalization;
use System\Entity\Repository\ItemTag;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Exception\Protocol\ItemsNotFoundException;
use System\Facade\TelegramFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class SearchFacade
 * @package System\Facade\Search
 */
class SearchFacade implements TelegramFacadeInterface
{
    use LoggerReferenceTrait;
    use SearchFacadeDependenciesTrait;
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
        $answerMessage = new AnswerMessage($request->getMessage()->getChat()->getId());
        $chat = $this->saveInfoForInteraction($request);

        if (empty($chat->getPhone())) {
            return $this->redirectToSavePhoneStage($request);
        }

        if ($chat->getCurrentSubStage() === SearchFacadeSubStage::ENTER_ITEM_NAME or $this->isPressButton($request)) {
            $chat->setCurrentSubStage(SearchFacadeSubStage::ENTER_ITEM_NAME);
            $answerMessage->setMessage($this->getMessage($request, $chat));
        } else {
            try {
                $keyboardValues = $this->generateKeyboardValues($request, $chat);
                $keyboard = TGKeyboard::keyboardWithCallbackData($keyboardValues);
                $answerMessage->setKeyboard($keyboard);

                $answerMessage->setMessage($this->getMessage($request, $chat));
            } catch (ItemsNotFoundException $e) {
                $chat->setCurrentSubStage(SearchFacadeSubStage::NO_RESULT);
                $this->getChatsRepository()->updateCurrentInfo($chat);
                $answerMessage->setMessage($this->getMessage($request, $chat));
            }
        }

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
        if ($chat->getCurrentStage() !== Stage::SEARCH) {
            $chat->setCurrentSubStage(SearchFacadeSubStage::ENTER_ITEM_NAME);
        } else {
            $chat->setCurrentSubStage(SearchFacadeSubStage::SELECT_ITEM);
        }
        $chat->setCurrentStage(Stage::SEARCH);
        $chat->setCurrentLocalization($this->getLocalization($telegramRequest));
        $this->getChatsRepository()->updateCurrentInfo($chat);
        $this->saveHistoryByChat($chat);

        return $chat;
    }

    /**
     * @param TelegramRequest $telegramRequest
     *
     * @return bool
     *
     * @throws DiException
     */
    private function isPressButton(TelegramRequest $telegramRequest): bool
    {
        $stage = $this->getButtonComponent()
            ->findStageByButtonName($telegramRequest->getMessage()->getText(), ButtonType::TEXT_BUTTON);

        return in_array($stage, [Stage::SEARCH]) ? true: false;
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
     * @param TelegramRequest $telegramRequest
     * @param Chat $chat
     *
     * @return KeyboardValue[]
     *
     * @throws DiException
     * @throws EmptyFetchResultException
     * @throws ItemsNotFoundException
     */
    private function generateKeyboardValues(TelegramRequest $telegramRequest, Chat $chat): array
    {
        $items = $this->findItems($telegramRequest->getMessage()->getText(), $telegramRequest);

        $keyboardValues= [];
        foreach ($items as $item) {
            $keyboardValues[] = new KeyboardValue(
                $item->getName(),
                $item->getItemId(),
                TGKeyboardAction::GET_ITEM_INPUT_FIELDS,
                $this->getButtonComponent()->findButton(TGButtons::PAGINATION_BACK, $chat->getCurrentLocalization())->getName(),
                $this->getButtonComponent()->findButton(TGButtons::PAGINATION_FORWARD, $chat->getCurrentLocalization())->getName(),
                TGKeyboardAction::GET_ITEMS
            );
        }

        return $keyboardValues;
    }

    /**
     * @param string $message
     * @param TelegramRequest $telegramRequest
     *
     * @return ItemLocalization[]
     *
     * @throws DiException
     * @throws ItemsNotFoundException
     */
    private function findItems(string $message, TelegramRequest $telegramRequest): array
    {
        $itemsTags = $this->getItemsTagsRepository()->findItemIdByTag($message);
        if (empty($itemsTags)) {
            $itemsTags = $this->getItemsTagsRepository()->findItemIdByTagWithoutRule($message);
            if (empty($itemsTags)) {
                throw new ItemsNotFoundException();
            }
        }
        $itemsId = [];
        foreach ($itemsTags as $itemTags) {
            $itemsId[] = $itemTags->getItemId();
        }
        $itemsLocalization = $this->getItemsLocalizationRepository()
            ->findItemsByIdAndLocale($itemsId, $this->getLocalization($telegramRequest));

        if (empty($itemsLocalization)) {
            throw new ItemsNotFoundException();
        }


        return $this->sortItems($itemsTags, $itemsLocalization,  $message);
    }

    /**
     * @param ItemTag[] $itemsTags
     * @param ItemLocalization[] $itemsLocalization
     * @param string $message
     *
     * @return array
     */
    private function sortItems(array $itemsTags, array $itemsLocalization, string $message): array
    {
        $length = count($itemsTags);
        for ($i = 0; $i < $length; $i++) {
            for ($j = 0; $j < $length - $i - 1; $j++) {
                $posSubstrCurrent = 0;
                $posSubstrNext = 0;

                foreach (explode(';', $itemsTags[$j]->getTags()) as $tag) {
                    $pos = strripos($tag, $message);
                    if ($pos > $posSubstrCurrent) {
                        $posSubstrCurrent = $pos;
                    }
                }

                foreach (explode(';', $itemsTags[$j+1]->getTags()) as $tag) {
                    $pos = strripos($tag, $message);
                    if ($pos > $posSubstrNext) {
                        $posSubstrNext = $pos;
                    }
                }

                if ($posSubstrCurrent < $posSubstrNext) {
                    $itemTags = $itemsTags[$j];
                    $itemsTags[$j] = $itemsTags[$j + 1];
                    $itemsTags[$j + 1] = $itemTags;
                } elseif ($posSubstrCurrent === $posSubstrNext) {
                    similar_text($itemsTags[$j]->getTags(), $message, $currentPercent);
                    similar_text($itemsTags[$j + 1]->getTags(), $message, $nextPercent);

                    if ($currentPercent > $nextPercent) {
                        $itemTags = $itemsTags[$j];
                        $itemsTags[$j] = $itemsTags[$j + 1];
                        $itemsTags[$j + 1] = $itemTags;
                    }
                }
            }
        }
        return $this->queueUpItems($itemsTags, $itemsLocalization);
    }

    /**
     * @param ItemTag[] $itemsTags
     * @param ItemLocalization[] $itemsLocalization
     *
     * @return ItemLocalization[]
     */
    private function queueUpItems(array $itemsTags, array $itemsLocalization): array
    {
        $items = [];

        foreach ($itemsTags as $itemTag) {
            foreach ($itemsLocalization as $itemLocalization) {
                if ($itemTag->getItemId() === $itemLocalization->getItemId()) {
                    array_unshift($items, $itemLocalization);
                }
            }
        }

        return array_chunk($items, 20)[0];
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