<?php

declare(strict_types=1);

namespace System\Facade\TelegramCallbackError;

use System\Entity\InternalProtocol\Request\Telegram\CallbackRequest;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\Repository\Chat;
use System\Entity\Repository\ChequeCallbackUrl;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Exception\Protocol\DatabaseDataNotFoundException;
use System\Facade\TelegramCallbackFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class TelegramCallbackErrorFacade
 * @package System\Facade\TelegramCallbackError
 */
class TelegramCallbackErrorFacade implements TelegramCallbackFacadeInterface
{
    use LoggerReferenceTrait;
    use TelegramCallbackErrorFacadeDependenciesTrait;
    use ChatHistoryTrait;

    /**
     * @param CallbackRequest $request
     *
     * @return AnswerMessage
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    public function process(CallbackRequest $request): AnswerMessage
    {
        try {
            $chequeCallBackUrl = $this->getChequesCallbackUrlsRepository()->findByGuid($request->getGuid());
            $chat = $this->getChatsRepository()->findByChequeId($chequeCallBackUrl->getChequeId());
        } catch (EmptyFetchResultException $e) {
            throw new DatabaseDataNotFoundException('Chat not found for page '.$request->getGuid());
        }

        if ($chequeCallBackUrl->getStatus() === ChequeCallbackUrl::NEW) {
            $this->saveInfoForInteraction($chat);
            $this->saveHistoryByChat($chat);
            $this->getChequesCallbackUrlsRepository()->updateStatus(
                $chequeCallBackUrl->getId(),
                ChequeCallbackUrl::ERROR
            );
        }

        $response = new AnswerMessage($chat->getProviderChatId());
        $response->setMessage(
            $this->getStageMessage($chat)
        );
        return $response;
    }

    /**
     * @param Chat $chat
     * @return string
     *
     * @throws DiException
     */
    private function getStageMessage(Chat $chat): string
    {
        try {
            $stageMessage = $this->getStagesMessagesRepository()->findMessage(
                Stage::GET_PAYMENT_PAGE,
                ChequeCallbackUrl::ERROR,
                $chat->getCurrentLocalization()
            );
            return $this->getMessageProcessingComponent()->fillMessage(new StageMessageVariables(), $stageMessage);
        } catch (EmptyFetchResultException $e) {
            $this->getLogger()->debug('StageMessage not found for stage '.Stage::GET_PAYMENT_PAGE.
                ' sub stage '.ChequeCallbackUrl::ERROR
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
        $chat->setCurrentSubStage(ChequeCallbackUrl::ERROR);

        $this->getChatsRepository()->updateCurrentStages($chat);
    }
}
