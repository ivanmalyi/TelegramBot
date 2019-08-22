<?php

declare(strict_types=1);

namespace System\Facade\TelegramCallbackOk;

use System\Entity\InternalProtocol\Currency;
use System\Entity\InternalProtocol\Request\Telegram\CallbackRequest;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\Repository\Chat;
use System\Entity\Repository\Cheque;
use System\Entity\Repository\ChequeCallbackUrl;
use System\Entity\Repository\Payment;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Exception\Protocol\DatabaseDataNotFoundException;
use System\Facade\TelegramCallbackFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class TelegramCallbackOkFacade
 * @package System\Facade\TelegramCallbackOk
 */
class TelegramCallbackOkFacade implements TelegramCallbackFacadeInterface
{
    use LoggerReferenceTrait;
    use TelegramCallbackOkFacadeDependenciesTrait;
    use ChatHistoryTrait;

    /**
     * @param CallbackRequest $request
     * @return AnswerMessage
     *
     * @throws DatabaseDataNotFoundException
     * @throws \System\Exception\DiException
     */
    public function process(CallbackRequest $request): AnswerMessage
    {
        try {
            $chequeCallBackUrl = $this->getChequesCallbackUrlsRepository()->findByGuid($request->getGuid());
            $cheque = $this->getChequesRepository()->findById($chequeCallBackUrl->getChequeId());
            $chat = $this->getChatsRepository()->findById($cheque->getChatId());
        } catch (EmptyFetchResultException $e) {
            throw new DatabaseDataNotFoundException('Chat not found for page '.$request->getGuid());
        }

        if ($chequeCallBackUrl->getStatus() === ChequeCallbackUrl::NEW) {
            $this->saveInfoForInteraction($chat);
            $chatHistoryId = $this->saveHistoryByChat($chat);

            $this->getChequesCallbackUrlsRepository()->updateStatus(
                $chequeCallBackUrl->getId(),
                ChequeCallbackUrl::OK_CARD_DATA_INPUT
            );

            $this->createNewPayment($cheque, $chatHistoryId);
        }

        $response = new AnswerMessage($chat->getProviderChatId());
        $response->setMessage(
            $this->getStageMessage($chat, $cheque)
        );
        return $response;
    }

    /**
     * @param Cheque $cheque
     * @param int $chatHistoryId
     *
     * @throws DiException
     */
    private function createNewPayment(Cheque $cheque, int $chatHistoryId): void
    {
        try {
            $this->getPaymentsRepository()->findByChequeId($cheque->getId());
        } catch (EmptyFetchResultException $e) {
            $payment = new Payment(
                $cheque->getId(),
                $cheque->getItemId(),
                $cheque->getAccount(),
                $cheque->getAmount(),
                $cheque->getCommission(),
                Payment::NEW,
                $cheque->getBillingChequeId(),
                0,
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s'),
                0,
                0,
                0,
                '',
                '',
                0,
                0,
                0,
                $chatHistoryId
            );
            $this->getPaymentsRepository()->create($payment);
        }
    }

    /**
     * @param Chat $chat
     * @param Cheque $cheque
     * @return string
     *
     * @throws DiException
     */
    private function getStageMessage(Chat $chat, Cheque $cheque): string
    {
        try {
            $stageMessage = $this->getStagesMessagesRepository()->findMessage(
                Stage::GET_PAYMENT_PAGE,
                ChequeCallbackUrl::OK_CARD_DATA_INPUT,
                $chat->getCurrentLocalization()
            );

            $stageMessageVariables = new StageMessageVariables();
            $stageMessageVariables->setAmount(Currency::kopeckToUah($cheque->getAmount()+$cheque->getCommission()));
            $stageMessageVariables->setAccount($cheque->getAccount()[0]);
            $stageMessageVariables->setBillingChequeId($cheque->getBillingChequeId());

            return $this->getMessageProcessingComponent()->fillMessage($stageMessageVariables, $stageMessage);
        } catch (EmptyFetchResultException $e) {
            $this->getLogger()->debug('StageMessage not found for stage '.Stage::GET_PAYMENT_PAGE.
                ' sub stage '.ChequeCallbackUrl::OK_CARD_DATA_INPUT
            );
            return 'Увы но я не знаю что сказать, обучи меня пожалуйста!';
        }
    }

    /**
     * @param Chat $chat
     * @throws DiException
     */
    private function saveInfoForInteraction(Chat $chat): void
    {
        $chat->setCurrentStage(Stage::GET_PAYMENT_PAGE);
        $chat->setCurrentSubStage(ChequeCallbackUrl::OK_CARD_DATA_INPUT);

        $this->getChatsRepository()->updateCurrentStages($chat);
    }
}
