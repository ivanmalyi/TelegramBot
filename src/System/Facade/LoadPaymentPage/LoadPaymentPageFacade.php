<?php

declare(strict_types=1);

namespace System\Facade\LoadPaymentPage;

use System\Component\PayBot\TGKeyboard;
use System\Entity\Component\Billing\LocalizationData;
use System\Entity\Component\Billing\Response\GetPaymentPageResponse;
use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\Currency;
use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Entity\InternalProtocol\ResponseCode;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\InternalProtocol\TGButtons;
use System\Entity\Repository\CallbackUrl;
use System\Entity\Repository\Chat;
use System\Entity\Repository\Cheque;
use System\Entity\Repository\ChequeCallbackUrl;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Exception\Protocol\DatabaseDataNotFoundException;
use System\Facade\TelegramFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

/**
 * Class LoadPaymentPageFacade
 * @package System\Facade\LoadPaymentPage
 */
class LoadPaymentPageFacade implements TelegramFacadeInterface
{
    use LoggerReferenceTrait;
    use LoadPaymentPageFacadeDependenciesTrait;
    use ChatHistoryTrait;

    /**
     * @param TelegramRequest $request
     *
     * @return AnswerMessage
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function process(TelegramRequest $request): AnswerMessage
    {
        $answerMessage = new AnswerMessage($request->getMessage()->getChat()->getId());

        $chat = $this->saveInfoForInteraction($request);
        $cheque = $this->findCheque($chat);
        $callbackUrl = $this->findCallbackUrls();

        $chequeCallBackUrl = $this->generatePageGuid($cheque, $callbackUrl);

        $response = $this->getBillingComponent()->getPaymentPage($cheque, $callbackUrl, $chequeCallBackUrl, $chat);
        if ($response->getResult() !== ResponseCode::SUCCESS_ACTION) {
            $answerMessage->setGoToStage(Stage::DEFAULT);
            return $answerMessage;
        }

        $imageUrl = $this->getItemImageUrl($cheque);
        if ($imageUrl !== '') {
            $answerMessage->setIsPicture(true);
            $answerMessage->setPictureUrl($imageUrl);
        }

        $answerMessage->setKeyboard($this->createPayButtons($request, $response));

        $answerMessage->setMessage($this->getMessage($chat, $cheque));
        return $answerMessage;
    }

    /**
     * @param Cheque $cheque
     * @param CallbackUrl $callbackUrl
     *
     * @return ChequeCallbackUrl
     *
     * @throws DiException
     */
    private function generatePageGuid(Cheque $cheque, CallbackUrl $callbackUrl): ChequeCallbackUrl
    {
        $pageGuid = ChequeCallbackUrl::generatePageGuid();
        try {
            $this->getChequesCallbackUrlsRepository()->findByGuid($pageGuid);
            return $this->generatePageGuid($cheque, $callbackUrl);
        } catch (EmptyFetchResultException $e) {
            $chequeCallBackUrl = new ChequeCallbackUrl(
                $pageGuid,
                ChequeCallbackUrl::NEW,
                $cheque->getId(),
                $callbackUrl->getId(),
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s')
            );

            $id = $this->getChequesCallbackUrlsRepository()->create($chequeCallBackUrl);
            $chequeCallBackUrl->setId($id);
            return $chequeCallBackUrl;
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
            throw new DatabaseDataNotFoundException('Чат не найден');
        }

        if ($chat->getCurrentStage() !== Stage::GET_PAYMENT_PAGE) {
            $chat->setCurrentStage(Stage::GET_PAYMENT_PAGE);
            $chat->setCurrentSubStage(LoadPaymentPageFacadeSubStage::TOTAL_AMOUNT);

            $this->getChatsRepository()->updateCurrentStages($chat);
            $this->saveHistoryByChat($chat);
        }
        return $chat;
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
            if ($cheque->getStatus() !== Cheque::OK) {
                throw new DatabaseDataNotFoundException(
                    'Cheque must have 21 status but '.$cheque->getStatus()
                );
            }
            return $cheque;
        } catch (EmptyFetchResultException $e) {
            throw new DatabaseDataNotFoundException('The cheque '.$chat->getCurrentChequeId().' not found');
        }
    }

    /**
     * @return CallbackUrl
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    private function findCallbackUrls(): CallbackUrl
    {
        try {
            return $this->getCallbackUrlsRepository()->findCallBackUrl(ChatBotId::TELEGRAM);
        } catch (EmptyFetchResultException $e) {
            throw new DatabaseDataNotFoundException('Callback urls not found');
        }
    }

    /**
     * @param Cheque $cheque
     * @return string
     * @throws DiException
     */
    private function getItemImageUrl(Cheque $cheque): string
    {
        try {
            $item = $this->getItemsRepository()->findById($cheque->getItemId());
            return 'https://images.fc-sistema.com/?image_name='.$item->getImage().'.png';
        } catch (EmptyFetchResultException $e) {
            return '';
        }
    }

    /**
     * @param TelegramRequest $telegramRequest
     * @param GetPaymentPageResponse $getPaymentPageResponse
     * @return InlineKeyboardMarkup
     * @throws DiException
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    private function createPayButtons(
        TelegramRequest $telegramRequest,
        GetPaymentPageResponse $getPaymentPageResponse
    ): InlineKeyboardMarkup
    {
        $localization = $this->getLocalization($telegramRequest);

        $payButton = ($this->getButtonComponent()->findButton(TGButtons::PAY, $localization))->getName();

        return TGKeyboard::payButtons($payButton, $getPaymentPageResponse);
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
     * @param Chat $chat
     * @param Cheque $cheque
     * @return string
     * @throws DiException
     */
    private function getMessage(Chat $chat, Cheque $cheque): string
    {
        try {
            $stageMessage = $this->getStagesMessagesRepository()->findMessage(
                $chat->getCurrentStage(),
                $chat->getCurrentSubStage(),
                $chat->getCurrentLocalization()
            );
            $this->getChatsRepository()->updateCurrentStages($chat);


            $stageMessageVariables = new StageMessageVariables();
            $stageMessageVariables->setAmount(Currency::kopeckToUah($cheque->getAmount()));
            $stageMessageVariables->setAccount(implode(', ', $cheque->getAccount()));
            $stageMessageVariables->setTotalAmount(
                Currency::kopeckToUah($cheque->getAmount()) + Currency::kopeckToUah($cheque->getCommission())
            );

            return $this->getMessageProcessingComponent()->fillMessage($stageMessageVariables, $stageMessage);
        } catch (EmptyFetchResultException $e) {
            $this->getLogger()->debug('StageMessage not found for '.$chat->getCurrentStage());
            return 'Увы но я не знаю что сказать, обучи меня пожалуйста!';
        }
    }
}
