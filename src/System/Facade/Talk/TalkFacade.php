<?php

declare(strict_types=1);

namespace System\Facade\Talk;


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
use System\Entity\Repository\ItemLocalization;
use System\Entity\Repository\ItemTag;
use System\Entity\Repository\StageMessage;
use System\Entity\Repository\Talk;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Exception\Protocol\ItemsNotFoundException;
use System\Facade\Search\SearchFacadeSubStage;
use System\Facade\TelegramFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\Logging\LoggerReferenceTrait;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

/**
 * Class TalkFacade
 * @package System\Facade\Talk
 */
class TalkFacade implements TelegramFacadeInterface
{
    use TalkFacadeDependenciesTrait;
    use LoggerReferenceTrait;

    const MATCH_THRESHOLD = 70;

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
        $chat = $this->findChat($request);
        if (empty($chat->getPhone())) {
            return $this->redirectToSavePhoneStage($request);
        }

        try {
            $this->checkOnItem($request, $answerMessage, $chat);
        } catch (ItemsNotFoundException $e) {
            $message = $this->findMessage($request, $chat);
            $answerMessage->setMessage($message);
        }

        if (is_null($answerMessage->getKeyboard())) {
            $answerMessage->setKeyboard($this->createNavigationKeyboard($request));
        }

        return $answerMessage;
    }

    /**
     * @param TelegramRequest $request
     *
     * @return Chat
     *
     * @throws DiException
     * @throws EmptyFetchResultException
     */
    private function findChat(TelegramRequest $request): Chat
    {
        $chat = $this->getChatsRepository()->findByProviderChatId(
            $request->getMessage()->getChat()->getId(),
            ChatBotId::TELEGRAM
        );

        $chat->setCurrentStage(Stage::TALK);
        $chat->setCurrentSubStage(0);
        $chat->setCurrentLocalization($this->getLocalization($request));

        return $chat;
    }

    /**
     * @param TelegramRequest $request
     * @param AnswerMessage $answerMessage
     * @param Chat $chat
     *
     * @return AnswerMessage
     *
     * @throws DiException
     * @throws EmptyFetchResultException
     * @throws ItemsNotFoundException
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    private function checkOnItem(TelegramRequest $request, AnswerMessage $answerMessage, Chat $chat): AnswerMessage
    {
        $keyboardValues = $this->generateKeyboardValues($request, $chat);
        $chat->setCurrentStage(Stage::SEARCH);
        $chat->setCurrentSubStage(SearchFacadeSubStage::SELECT_ITEM);

        $keyboard = TGKeyboard::keyboardWithCallbackData($keyboardValues);
        $answerMessage->setKeyboard($keyboard);

        $message = $this->getMessageProcessingComponent()->fillMessage(
            new StageMessageVariables(),
            new StageMessage(0,0, $chat->getCurrentLocalization(), $this->getMessage($chat), 0)
        );

        $answerMessage->setMessage($message);

        return $answerMessage;
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
        $items = $this->findItems($telegramRequest);

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
     * @param TelegramRequest $telegramRequest
     *
     * @return ItemLocalization[]
     *
     * @throws DiException
     * @throws ItemsNotFoundException
     */
    private function findItems(TelegramRequest $telegramRequest): array
    {
        $message = trim($telegramRequest->getMessage()->getText());
        if (empty($message)) {
            throw new ItemsNotFoundException();
        }

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
     * @param array $itemsTags
     * @param array $itemsLocalization
     * @param string $message
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
     * @param Chat $chat
     *
     * @return string
     *
     * @throws DiException
     */
    private function getMessage(Chat $chat): string
    {
        try {
            $stageMessage = $this->getStagesMessagesRepository()->findMessage(
                $chat->getCurrentStage(),
                $chat->getCurrentSubStage(),
                $chat->getCurrentLocalization()
            );

            return $stageMessage->getMessage();
        } catch (EmptyFetchResultException $e) {
            $this->getLogger()->debug('StageMessage not found for ' . $chat->getCurrentStage());
            return 'Увы но я не знаю что сказать, обучи меня пожалуйста!';

        }
    }

    /**
     * @param TelegramRequest $request
     * @param Chat $chat
     *
     * @return string
     *
     * @throws DiException
     */
    private function findMessage(TelegramRequest $request, Chat $chat)
    {
        $userQuestion = trim($request->getMessage()->getText());
        $maxPercent = 0;
        $currentPercent = 0;
        $lastTalkId = 0;
        $similarTalks = [];
        $message = '';

        if (!empty($userQuestion)) {
            while (true) {
                $talks = $this->getTalkRepository()->findTalks($lastTalkId);
                foreach ($talks as $talk) {
                    similar_text($talk->getQuestion(), $userQuestion, $currentPercent);

                    if ($currentPercent >= TalkFacade::MATCH_THRESHOLD) {
                        if ($maxPercent < $currentPercent) {
                            $similarTalks = [];
                            $similarTalks[] = $talk;
                            $maxPercent = $currentPercent;
                        } elseif ($maxPercent === $currentPercent) {
                            $similarTalks[] = $talk;
                        }
                    }
                }

                if (empty($talks)) {
                    break;
                } else {
                    $lastTalkId = $talk->getId();
                }

                unset($talks);
            }
        }

        if (!empty($similarTalks)) {
            $message = $this->findRandomAnswer($similarTalks);
        }

        if (empty($similarTalks) or empty($message)) {
            if (!empty($userQuestion)) {
                $this->getTalkRepository()->saveQuestionWithoutAnswer($userQuestion);
            }
            $message = $this->getMessage($chat);
        }

        return $this->getMessageProcessingComponent()->fillMessage(
            new StageMessageVariables(),
            new StageMessage(0,0, $chat->getCurrentLocalization(), $message, 0)
        );
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
     * @param Talk[] $similarTalks
     *
     * @return string
     */
    private function findRandomAnswer(array $similarTalks): string
    {
        $randIndex = rand(0, count($similarTalks) - 1);

        return  $similarTalks[$randIndex]->getAnswer();
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
}