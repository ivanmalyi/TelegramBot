<?php

declare(strict_types=1);

namespace System\Facade\Verify;

use System\Entity\Component\Billing\BillingResponseCode;
use System\Entity\Component\Billing\LocalizationData;
use System\Entity\Component\Billing\Response\VerifyResponse;
use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\Currency;
use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\Repository\Chat;
use System\Entity\Repository\Cheque;
use System\Entity\Repository\ItemType;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Exception\Protocol\DatabaseDataNotFoundException;
use System\Facade\TelegramFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class VerifyFacade
 * @package System\Facade\Verify
 */
class VerifyFacade implements TelegramFacadeInterface
{
    use LoggerReferenceTrait;
    use VerifyFacadeDependenciesTrait;
    use ChatHistoryTrait;

    /**
     * @param TelegramRequest $request
     * @return AnswerMessage
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    public function process(TelegramRequest $request): AnswerMessage
    {
        $answerMessage = new AnswerMessage($request->getMessage()->getChat()->getId());

        $chat = $this->saveInfoForInteraction($request);
        $cheque = $this->findCheque($chat);

        $verifyResponse = $this->verify($cheque);
        if ($verifyResponse->getResult() === BillingResponseCode::SUCCESS_ACTION) {
            if ($verifyResponse->getStatus() === Cheque::OK) {
                $display = $verifyResponse->getDisplay();
                
                if ($display->getPayAmount() !== 0 and $display->isModifyPayAmount() === false) {
                    $cheque->setAmount($display->getPayAmount());
                    $this->saveCheque($cheque);

                    $answerMessage->setGoToStage(Stage::CALCULATE_COMMISSION);
                    $message = $this->getMessage(
                        $request,
                        $chat->getCurrentStage(),
                        Cheque::EXACT_AMOUNT,
                        Currency::kopeckToUah($display->getPayAmount())
                    );
                    $answerMessage->setMessage($message);
                    return $answerMessage;
                } elseif ($display->getMinPayAmount() !== 0 and $display->getMinPayAmount() === $display->getMaxPayAmount()) {
                    $cheque->setAmount($display->getMinPayAmount());
                    $this->saveCheque($cheque);

                    $answerMessage->setGoToStage(Stage::CALCULATE_COMMISSION);
                    $message = $this->getMessage(
                        $request,
                        $chat->getCurrentStage(),
                        Cheque::EXACT_AMOUNT,
                        Currency::kopeckToUah($display->getPayAmount())
                    );
                    $answerMessage->setMessage($message);
                    return $answerMessage;
                }

                $this->saveVerifyData($verifyResponse, $cheque);
                $answerMessage->setMessage(trim($verifyResponse->getDisplay()->getText()));
                $answerMessage->setGoToStage(Stage::GET_COMMISSIONS);

                $chat->setAttempts(-1);
                $this->checkAttempts($chat, $answerMessage);
                return $answerMessage;
            } else {
                $answerMessage->setGoToStage(Stage::GET_ITEM_INPUT_FIELDS);
                $message = $this->getMessage($request, $chat->getCurrentStage(), $verifyResponse->getStatus());
                $answerMessage->setMessage($message);
                $this->checkAttempts($chat, $answerMessage);
                return $answerMessage;
            }
        }

        $this->checkAttempts($chat, $answerMessage);

        $message = $this->getMessage(
            $request,
            $chat->getCurrentStage(),
            Cheque::PROVIDER_ERROR
        );
        $answerMessage->setMessage($message);
        return $answerMessage;
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

        if ($chat->getCurrentStage() !== Stage::VERIFY) {
            $chat->setCurrentStage(Stage::VERIFY);
            $chat->setCurrentSubStage(0);
            $this->getChatsRepository()->updateCurrentStages($chat);
        }
        $this->saveHistoryByChat($chat);

        return $chat;
    }

    /**
     * @param Cheque $cheque
     *
     * @return VerifyResponse
     *
     * @throws DiException
     */
    private function verify(Cheque $cheque): VerifyResponse
    {
        $itemTypes = $this->getItemTypesRepository()->findTypesForItem($cheque->getItemId());
        if (in_array(ItemType::GROUP_OF_PAYMENT, $itemTypes)) {
            $verifyResponse = $this->getBillingComponent()->verifyPackage($cheque);
        } else {
            $verifyResponse = $this->getBillingComponent()->verify($cheque);
        }


        if ($verifyResponse->getResult() === BillingResponseCode::SUCCESS_ACTION) {
            $cheque->setStatus($verifyResponse->getStatus());
            $cheque->setBillingChequeId($verifyResponse->getChequeId());
            $cheque->setPaymentSystemId($verifyResponse->getPaymentSystemId());

            if ($verifyResponse->getItemId() !== 0) {
                $cheque->setItemId($verifyResponse->getItemId());
            }

            $this->getChequesRepository()->updateCheque($cheque);
        }

        return $verifyResponse;
    }

    /**
     * @param TelegramRequest $telegramRequest
     * @param float $amount
     * @param int $currentStage
     * @param int $subStage
     *
     * @return string
     *
     * @throws DiException
     */
    private function getMessage(
        TelegramRequest $telegramRequest,
        int $currentStage,
        int $subStage = 0,
        float $amount = 0.00
    ): string
    {
        try {
            $stageMessage = $this->getStagesMessagesRepository()->findMessage(
                $currentStage,
                $subStage,
                $this->getLocalization($telegramRequest)
            );

            $stageMessageVariables = new StageMessageVariables();
            $stageMessageVariables->setFio(
                $telegramRequest->getMessage()->getChat()->getFirstName() . ' ' .
                $telegramRequest->getMessage()->getChat()->getLastName()
            );
            $stageMessageVariables->setAmount($amount);

            return $this->getMessageProcessingComponent()->fillMessage($stageMessageVariables, $stageMessage);
        } catch (EmptyFetchResultException $e) {
            $this->getLogger()->debug('StageMessage not found for '.$currentStage);
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
        } catch (\Throwable $e) {
        }
        return LocalizationData::RU;
    }

    /**
     * @param VerifyResponse $verifyResponse
     * @param Cheque $cheque
     * @throws DiException
     */
    private function saveVerifyData(VerifyResponse $verifyResponse, Cheque $cheque): void
    {
        if (!is_null($verifyResponse->getDisplay())) {
            $this->getDisplayRepository()->saveDisplay($verifyResponse->getDisplay(), $cheque->getId());
        }

        if (!is_null($verifyResponse->getChequesPrint())) {
            $this->getChequePrintRepository()->saveChequesPrint($verifyResponse->getChequesPrint(), $cheque->getId());
        }

        if (!is_null($verifyResponse->getAcquiringCommissions())) {
            $this->getAcquiringCommissionRepository()
                ->saveAcquiringCommissions($verifyResponse->getAcquiringCommissions(), $cheque->getId());
        }
    }

    /**
     * @param Cheque $cheque
     * @return int
     * @throws DiException
     */
    private function saveCheque(Cheque $cheque): int
    {
       return $this->getChequesRepository()->updateCheque($cheque);
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