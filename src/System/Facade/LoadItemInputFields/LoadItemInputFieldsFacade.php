<?php

declare(strict_types=1);

namespace System\Facade\LoadItemInputFields;

use System\Component\PayBot\TGKeyboard;
use System\Entity\Component\Billing\LocalizationData;
use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\KeyboardValue;
use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\InternalProtocol\TGButtons;
use System\Entity\Repository\Chat;
use System\Entity\Repository\Cheque;
use System\Entity\Repository\ChequeCallbackUrl;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Exception\Protocol\DatabaseDataNotFoundException;
use System\Exception\Protocol\ItemInputFieldNotFound;
use System\Exception\ValidateAccountException;
use System\Facade\TelegramFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

/**
 * Class LoadItemInputFieldsFacade
 * @package System\Facade\LoadItemInputFields
 */
class LoadItemInputFieldsFacade implements TelegramFacadeInterface
{
    use LoggerReferenceTrait;
    use LoadItemInputFieldsFacadeDependenciesTrait;
    use ChatHistoryTrait;

    /**
     * @var bool
     */
    private $isMobile = false;

    /**
     * @param TelegramRequest $request
     *
     * @return AnswerMessage
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     * @throws EmptyFetchResultException
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function process(TelegramRequest $request): AnswerMessage
    {
        $answerMessage = new AnswerMessage($request->getMessage()->getChat()->getId());

        $chat = $this->saveInfoForInteraction($request);

        if ($this->isNeedBindToAccountCurrentUserPhoneNumber($request)) {
            $chat->setAttempts(-1);
            $this->checkAttempts($chat, $answerMessage);

            $cheque = $this->findCheque($chat);
            try {
                $this->saveToFieldCurrentUserPhoneNumber($chat, $cheque);
                $message = $this->getMessage($chat, $cheque);
            } catch (ItemInputFieldNotFound $e) {
                $message = '';
                $answerMessage->setGoToStage(Stage::VERIFY);
            }
        } elseif ($request->getCallbackData() !== null) {
            $this->createCheque($request, $chat);
            $message = $this->getMessageByCallback($request, $chat);

            $chat->setAttempts(-1);
            $this->checkAttempts($chat, $answerMessage);
        } else {
            $cheque = $this->findCheque($chat);
            try {
                $this->saveMessageText($request, $chat, $cheque);
                $message = $this->getMessage($chat, $cheque);
            } catch (ItemInputFieldNotFound $e) {
                $message = '';
                $answerMessage->setGoToStage(Stage::VERIFY);
                $chat->setAttempts(-1);
                $this->checkAttempts($chat, $answerMessage);
            } catch (ValidateAccountException $e) {
                $message = $this->getMessageWithIncorrectStatus($request, $chat);
                $this->checkAttempts($chat, $answerMessage);
            }
        }

        $answerMessage->setMessage($message);
        if ($this->isMobile and strlen($chat->getPhone()) === 12) {
            $answerMessage->setKeyboard(
                $this->generateCurrentMobilePhoneForInputFiledButton($request, $chat->getPhone())
            );
        }
        return $answerMessage;
    }

    /**
     * @param TelegramRequest $request
     * @return bool
     */
    private function isNeedBindToAccountCurrentUserPhoneNumber(TelegramRequest $request): bool
    {
        if ($request->getCallbackData() !== null and
            $request->getCallbackData()->getButtonId() === TGButtons::BIND_USER_PHONE_NUMBER_TO_INPUT_FIELD) {
            return true;
        }
        return false;
    }

    /**
     * @param Chat $chat
     * @param Cheque $cheque
     * @throws DiException
     */
    private function saveToFieldCurrentUserPhoneNumber(Chat $chat, Cheque $cheque): void
    {
        $accounts = $cheque->getAccount();
        $accounts[$chat->getCurrentSubStage()-1] = $chat->getPhone();
        $cheque->setAccount($accounts);

        $this->getChequesRepository()->updateCheque($cheque);
    }

    /**
     * @param TelegramRequest $request
     * @param string $userPhoneNumber
     *
     * @return InlineKeyboardMarkup|null
     *
     * @throws DiException
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    private function generateCurrentMobilePhoneForInputFiledButton(
        TelegramRequest $request,
        string $userPhoneNumber
    ): ?InlineKeyboardMarkup
    {
        try {
            $variables = new StageMessageVariables();
            $variables->setCurrentPhoneNumber($userPhoneNumber);

            $button = $this->getButtonComponent()->findButton(
                TGButtons::BIND_USER_PHONE_NUMBER_TO_INPUT_FIELD,
                $this->getLocalization($request),
                $variables
            );

            $keyboardValue = new KeyboardValue(
                $button->getName(),
                $button->getId(),
                $button->getCallBackAction()
            );
            return TGKeyboard::keyboardWithCallbackData([$keyboardValue]);
        } catch (EmptyFetchResultException $e) {
            return null;
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
     *
     * @return Chat
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    private function saveInfoForInteraction(TelegramRequest $telegramRequest): Chat
    {
        try {
            $chat = $this->getChatsRepository()->findByProviderChatId(
                $telegramRequest->getMessage()->getChat()->getId(),
                ChatBotId::TELEGRAM
            );
        } catch (EmptyFetchResultException $e) {
            $this->getLogger()->debug('Чат не найден '.$telegramRequest->getMessage()->getChat()->getId());
            throw new DatabaseDataNotFoundException('Чат не найден');
        }

        if ($this->isNeedBindToAccountCurrentUserPhoneNumber($telegramRequest) and
            $chat->getCurrentStage() !== Stage::GET_ITEM_INPUT_FIELDS) {
            return $chat;
        }

        if ($chat->getCurrentStage() === Stage::GET_PAYMENT_PAGE and in_array($chat->getCurrentSubStage(), [
                ChequeCallbackUrl::OK_CARD_DATA_INPUT, ChequeCallbackUrl::ERROR
            ])) {
            $chat->setCurrentSessionGuid(Chat::generateSessionGuid());
        }
        if ($chat->getCurrentStage() !== Stage::GET_ITEM_INPUT_FIELDS) {
            $chat->setCurrentStage(Stage::GET_ITEM_INPUT_FIELDS);
            $chat->setCurrentSubStage(0);
            $chat->setCurrentLocalization($this->getLocalization($telegramRequest));
            $this->getChatsRepository()->updateCurrentInfo($chat);
        } elseif ($chat->getCurrentLocalization() !== $this->getLocalization($telegramRequest)) {
            $chat->setCurrentLocalization($this->getLocalization($telegramRequest));
            $this->getChatsRepository()->updateCurrentInfo($chat);
        }
        $this->saveHistoryByChat($chat);

        return $chat;
    }

    /**
     * @param TelegramRequest $request
     * @param Chat $chat
     *
     * @return string
     *
     * @throws DiException
     */
    private function getMessageByCallback(TelegramRequest $request, Chat $chat): string
    {
        try {
            $itemInputField = $this->getItemsInputFieldsRepository()->findByItemIdAndOrder(
                $request->getCallbackData()->getButtonId(),
                1
            );
            if ($itemInputField->getisMobile() === 1) {
                $this->isMobile = true;
            }
            $itemInputFieldLocalization = $this->getItemsInputFieldsLocalizationRepository()->findByItemInputId(
                $itemInputField->getId(),
                $chat->getCurrentLocalization()
            );

            $chat->setCurrentSubStage($itemInputField->getOrder());
            $this->getChatsRepository()->updateCurrentSubStage($chat);

            return $itemInputFieldLocalization->getInstruction();
        } catch (EmptyFetchResultException $e) {
            $this->getLogger()->debug(
                'ItemInputField(Localization) not found for item '.$request->getCallbackData()->getButtonId()
            );
            return 'Извини, не могу найти инструкции ввода. Странно! Сообщу ка я разработчикам';
        }
    }

    /**
     * @param TelegramRequest $request
     * @param Chat $chat
     *
     * @return void
     *
     * @throws DiException
     */
    private function createCheque(TelegramRequest $request, Chat $chat): void
    {
        try {
            $cheque = $this->getChequesRepository()->findById($chat->getCurrentChequeId());
            if ($cheque->getStatus() !== Cheque::NEW) {
                $this->createNewCheque($request, $chat);
            }
            if ($cheque->getItemId() !== $request->getCallbackData()->getButtonId()) {
                $cheque->setItemId($request->getCallbackData()->getButtonId());
                $this->getChequesRepository()->updateCheque($cheque);
            }
        } catch (EmptyFetchResultException $e) {
            $this->createNewCheque($request, $chat);
        }
    }

    /**
     * @param TelegramRequest $request
     * @param Chat $chat
     *
     * @return Cheque
     *
     * @throws DiException
     */
    private function createNewCheque(TelegramRequest $request, Chat $chat): Cheque
    {
        $cheque = new Cheque(
            $chat->getId(),
            $chat->getUserId(),
            [],
            $request->getCallbackData()->getButtonId(),
            0,
            Cheque::NEW,
            0,
            0
        );
        $cheque->setId(
            $this->getChequesRepository()->create($cheque)
        );

        $chat->setCurrentChequeId($cheque->getId());
        $this->getChatsRepository()->updateCurrentInfo($chat);

        return $cheque;
    }

    /**
     * @param Chat $chat
     *
     * @return Cheque
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    private function findCheque(Chat $chat): Cheque
    {
        try {
            $cheque = $this->getChequesRepository()->findById($chat->getCurrentChequeId());
            if ($cheque->getStatus() !== Cheque::NEW) {
                throw new DatabaseDataNotFoundException(
                    'Cheque must have 0 status but '.$cheque->getStatus()
                );
            }
            return $cheque;
        } catch (EmptyFetchResultException $e) {
            throw new DatabaseDataNotFoundException('A cheque '.$chat->getCurrentChequeId().' not found');
        }
    }

    /**
     * @param TelegramRequest $request
     * @param Chat $chat
     * @param Cheque $cheque
     *
     * @throws DiException
     * @throws EmptyFetchResultException
     * @throws ValidateAccountException
     */
    private function saveMessageText(TelegramRequest $request, Chat $chat, Cheque $cheque): void
    {
        $accounts = $cheque->getAccount();
        $accounts[$chat->getCurrentSubStage()-1] = $this->validateAccount($request, $cheque, $chat);
        $cheque->setAccount($accounts);

        $this->getChequesRepository()->updateCheque($cheque);
    }

    /**
     * @param TelegramRequest $request
     * @param Cheque $cheque
     * @param Chat $chat
     *
     * @return string
     *
     * @throws DiException
     * @throws EmptyFetchResultException
     * @throws ValidateAccountException
     */
    private function validateAccount(TelegramRequest $request, Cheque $cheque, Chat $chat): string
    {
        $itemInputField = $this->getItemsInputFieldsRepository()->findByItemIdAndOrder(
            $cheque->getItemId(),
            $chat->getCurrentSubStage()
        );

        $account = trim($request->getMessage()->getText());
        if ($itemInputField->getisMobile()) {
           $account = $this->formatPhoneNumber($account);
        }

        return $account;
    }

    /**
     * @param string $phone
     *
     * @return string
     *
     * @throws ValidateAccountException
     */
    private function formatPhoneNumber(string $phone): string
    {
        $phone = preg_quote($phone);
        $phone = str_replace('\+', '+', $phone);
        $isMobile = preg_match("/^((\+?3)?8)?0\d{9}$/", $phone);
        if ($isMobile) {
            if (strlen($phone) === 13) {
                $phone = ltrim($phone, '+');
            } elseif (strlen($phone) === 11) {
                $phone = "3{$phone}";
            } elseif (strlen($phone) === 10) {
                $phone = "38{$phone}";
            }
        } else {
            throw new ValidateAccountException();
        }

        return $phone;
    }

    /**
     * @param Chat $chat
     * @param Cheque $cheque
     *
     * @return string
     *
     * @throws DiException
     * @throws ItemInputFieldNotFound
     */
    private function getMessage(Chat $chat, Cheque $cheque): string
    {
        try {
            $itemInputField = $this->getItemsInputFieldsRepository()->findByItemIdAndOrder(
                $cheque->getItemId(),
                $chat->getCurrentSubStage()+1
            );
            if ($itemInputField->getisMobile() === 1) {
                $this->isMobile = true;
            }
            $itemInputFieldLocalization = $this->getItemsInputFieldsLocalizationRepository()->findByItemInputId(
                $itemInputField->getId(),
                $chat->getCurrentLocalization()
            );

            $chat->setCurrentSubStage($itemInputField->getOrder());
            $this->getChatsRepository()->updateCurrentSubStage($chat);

            return $itemInputFieldLocalization->getInstruction();
        } catch (EmptyFetchResultException $e) {
            throw new ItemInputFieldNotFound();
        }
    }

    /**
     * @param TelegramRequest $telegramRequest
     * @param Chat $chat
     * @return string
     *
     * @throws DiException
     */
    private function getMessageWithIncorrectStatus(TelegramRequest $telegramRequest, Chat $chat): string
    {
        try {
            $stageMessage = $this->getStagesMessagesRepository()->findMessage(
                $chat->getCurrentStage(),
                0,
                $chat->getCurrentLocalization()
            );
            $stageMessageVariables = new StageMessageVariables();
            $stageMessageVariables->setFio($telegramRequest->getMessage()->getChat()->getFirstName());

            return $this->getMessageProcessingComponent()->fillMessage($stageMessageVariables, $stageMessage);
        } catch (EmptyFetchResultException $e) {
            $this->getLogger()->debug('StageMessage not found for '.$chat->getCurrentStage());
            return 'Увы но я не знаю что сказать, обучи меня пожалуйста!';
        }
    }

    /**
     * @param Chat $chat
     * @param AnswerMessage $answerMessage
     *
     * @throws DiException
     */
    private function checkAttempts(Chat $chat, AnswerMessage $answerMessage): void
    {
        $attempts = $chat->getAttempts();
        if ($attempts > 1) {
            $chat->setAttempts(0);
            $this->getChatsRepository()->updateAttempts($chat);
            $answerMessage->setGoToStage(Stage::MAIN_MENU);
        } else {
            $chat->setAttempts($attempts + 1);
            $this->getChatsRepository()->updateAttempts($chat);
        }
    }
}
