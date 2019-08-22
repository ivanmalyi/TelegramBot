<?php

declare(strict_types=1);

namespace System\Facade\TelegramCallback3ds;

use System\Console\Service\Pay\PayStageMessages;
use System\Entity\InternalProtocol\Currency;
use System\Entity\InternalProtocol\Request\Telegram\CallbackRequest;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\Repository\Chat;
use System\Entity\Repository\Cheque;
use System\Entity\Repository\ChequeCallbackUrl;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Exception\Protocol\DatabaseDataNotFoundException;
use System\Facade\TelegramCallbackFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;

class TelegramCallback3dsFacade implements TelegramCallbackFacadeInterface
{
    use LoggerReferenceTrait;
    use TelegramCallback3dsFacadeDependenciesTrait;
    use ChatHistoryTrait;

    /**
     * @param CallbackRequest $request
     *
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

        if ($chequeCallBackUrl->getStatus() === ChequeCallbackUrl::OK_CARD_DATA_INPUT) {
            $this->saveInfoForInteraction($chat);
            $this->saveHistoryByChat($chat);
            $this->getChequesCallbackUrlsRepository()->updateStatus(
                $chequeCallBackUrl->getId(),
                ChequeCallbackUrl::SECURE_3D
            );
        }

        $response = new AnswerMessage($chat->getProviderChatId());
        $response->setMessage(
            $this->getStageMessage($chat, $cheque)
        );
        return $response;
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
                Stage::PAY,
                PayStageMessages::SECURE_3D_WAITING,
                $chat->getCurrentLocalization()
            );

            $stageMessageVariables = new StageMessageVariables();
            $stageMessageVariables->setAmount(Currency::kopeckToUah($cheque->getAmount()));
            $stageMessageVariables->setAccount($cheque->getAccount()[0]);
            $stageMessageVariables->setBillingChequeId($cheque->getBillingChequeId());

            return $this->getMessageProcessingComponent()->fillMessage($stageMessageVariables, $stageMessage);
        } catch (EmptyFetchResultException $e) {
            $this->getLogger()->debug('StageMessage not found for stage '.Stage::PAY.
                ' sub stage '.PayStageMessages::SECURE_3D_WAITING
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
        $chat->setCurrentSubStage(ChequeCallbackUrl::SECURE_3D);

        $this->getChatsRepository()->updateCurrentStages($chat);
    }
}
