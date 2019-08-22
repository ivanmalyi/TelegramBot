<?php

declare(strict_types=1);

namespace System\Action;

use System\Entity\InternalProtocol\ButtonType;
use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\Request\Telegram\CallbackData;
use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Entity\InternalProtocol\Stage;
use System\Exception\EmptyFetchResultException;
use System\Exception\Protocol\UnknownCommandException;
use System\Facade\TelegramFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Kernel\Protocol\RequestBundle;

/**
 * Class TelegramController
 * @package System\Controller
 */
class TelegramAction extends AbstractAction
{
    use TelegramActionDependenciesTrait;

    /**
     * @param RequestBundle $request
     *
     * @throws UnknownCommandException
     * @throws \System\Exception\DiException
     * @throws \System\Exception\Protocol\MissingArgumentException
     * @throws \System\Exception\Protocol\ValidateArgumentException
     */
    public function handle(RequestBundle $request): void
    {
        $telegramRequest = TelegramRequest::validation($request);
        $isIntegrationTesting = $request->getParams()['IsIntegrationTesting'];
        $answerMessage = $this->processRequest($telegramRequest, 0, $isIntegrationTesting);

        $this->sendAnswerMessage($answerMessage);
    }

    /**
     * @param AnswerMessage $answerMessage
     *
     * @throws \System\Exception\DiException
     */
    private function sendAnswerMessage(AnswerMessage $answerMessage): void
    {
        if ($answerMessage->isPicture()) {
            $this->getPayBot()->sendPicture($answerMessage);
        } elseif ($answerMessage->isUpdateKeyboard()) {
            $this->getPayBot()->updateKeyboard($answerMessage);
        } else {
            $this->getPayBot()->sendUserMessage($answerMessage);
        }
    }

    /**
     * @param TelegramRequest $request
     * @param int $stage
     * @param bool $isIntegrationTesting
     *
     * @return AnswerMessage
     *
     * @throws UnknownCommandException
     * @throws \System\Exception\DiException
     * @throws \System\Exception\Protocol\MissingArgumentException
     * @throws \System\Exception\Protocol\ValidateArgumentException
     */
    private function processRequest(TelegramRequest $request, int $stage = 0, bool $isIntegrationTesting = false): AnswerMessage
    {

        $telegramMessage = trim($request->getMessage()->getText());

        if ($stage === 0 and $request->getCallbackData() === null) {
            $stage = $this->getButtonComponent()->findStageByButtonName($telegramMessage, ButtonType::TEXT_BUTTON);
        }

        if (Stage::isStart($request, $stage)) {
            $answerMessage = $this->getTGFacadeFromDI('facade.start')->process($request);
        } elseif (Stage::isSavePhone($request, $stage)) {
            $answerMessage = $this->getTGFacadeFromDI('facade.savePhone')->process($request);
        }elseif (Stage::isMainMenu($request, $stage)) {
            $answerMessage = $this->getTGFacadeFromDI('facade.mainMenu')->process($request);
        } elseif (Stage::isGetSections($request, $stage)) {
            $answerMessage = $this->getTGFacadeFromDI('facade.getSections')->process($request);
        } elseif (Stage::isGetOperators($request, $stage)) {
            $answerMessage = $this->getTGFacadeFromDI('facade.getOperators')->process($request);
        } elseif (Stage::isGetServices($request, $stage)) {
            $answerMessage = $this->getTGFacadeFromDI('facade.loadServices')->process($request);
        } elseif (Stage::isGetItems($request, $stage)) {
            $answerMessage = $this->getTGFacadeFromDI('facade.loadItems')->process($request);
        } elseif (Stage::isGetItemInputFields($request, $stage)) {
            $answerMessage = $this->getTGFacadeFromDI('facade.loadItemInputFields')->process($request);
        } elseif (Stage::VERIFY === $stage) {
            if ($isIntegrationTesting) {
                $facadeDiKey = 'facade.verify.test';
            } else {
                $facadeDiKey = 'facade.verify';
            }
            $answerMessage = $this->getTGFacadeFromDI($facadeDiKey)->process($request);
            if ($answerMessage->getGoToStage() === Stage::GET_ITEM_INPUT_FIELDS) {
                $this->sendAnswerMessage($answerMessage);
                $answerMessage = $this->processRequestByPreviousStage($request, $isIntegrationTesting);
            }
        } elseif (Stage::GET_COMMISSIONS === $stage) {
            $answerMessage = $this->getTGFacadeFromDI('facade.loadCommissions')->process($request);
        } elseif (Stage::GET_AMOUNT === $stage) {
            $answerMessage = $this->getTGFacadeFromDI('facade.loadAmount')->process($request);
        } elseif (Stage::CALCULATE_COMMISSION === $stage) {
            $answerMessage = $this->getTGFacadeFromDI('facade.calculateCommission')->process($request);
        } elseif (Stage::GET_PAYMENT_PAGE === $stage) {
            $answerMessage = $this->getTGFacadeFromDI('facade.loadPaymentPage')->process($request);
        } elseif (Stage::isSearch($stage) and $request->getCallbackData() === null) {
            $answerMessage = $this->getTGFacadeFromDI('facade.search')->process($request);
        } elseif ($stage === Stage::PRIVATE_OFFICE and $request->getCallbackData() === null){
            $answerMessage = $this->getTGFacadeFromDI('facade.privateOffice')->process($request);
        } elseif (Stage::isCardManagement($request, $stage)) {
            $answerMessage = $this->getTGFacadeFromDI('facade.cardManagement')->process($request);
        } elseif ($request->getCallbackData() === null and $telegramMessage !== '' and $stage === 0) {
            $answerMessage = $this->processRequestByPreviousStage($request, $isIntegrationTesting);
        } else {
            $answerMessage = $this->getTGFacadeFromDI('facade.talk')->process($request);
        }

        if ($answerMessage->getGoToStage() !== 0) {
            if ($answerMessage->getMessage() !== '' or $answerMessage->isPicture()) {
                $this->sendAnswerMessage($answerMessage);
            }

            if ($answerMessage->getCallbackData() !== null) {
                $request->setCallbackData($answerMessage->getCallbackData());
            }
            return $this->processRequest($request, $answerMessage->getGoToStage(), $isIntegrationTesting);
        }

        return $answerMessage;
    }

    /**
     * @param TelegramRequest $request
     * @param bool $isIntegrationTesting
     *
     * @return AnswerMessage
     *
     * @throws UnknownCommandException
     * @throws \System\Exception\DiException
     * @throws \System\Exception\Protocol\MissingArgumentException
     * @throws \System\Exception\Protocol\ValidateArgumentException
     */
    private function processRequestByPreviousStage(TelegramRequest $request, bool $isIntegrationTesting): AnswerMessage
    {
        try {
            $chat = $this->getChatsRepository()->findByProviderChatId(
                $request->getMessage()->getChat()->getId(),
                ChatBotId::TELEGRAM
            );

            if ($chat->getCurrentStage() === Stage::GET_ITEM_INPUT_FIELDS) {
                return $this->processRequest($request, $chat->getCurrentStage(), $isIntegrationTesting);
            } elseif ($chat->getCurrentStage() === Stage::GET_AMOUNT) {
                return $this->processRequest($request, $chat->getCurrentStage(), $isIntegrationTesting);
            } elseif ($chat->getCurrentStage() === Stage::SEARCH) {
                return $this->processRequest($request, $chat->getCurrentStage(), $isIntegrationTesting);
            } elseif ($chat->getCurrentStage() === Stage::VERIFY) {
                $callBackData = CallbackData::validation(
                    [
                        'KbAction'=>'GetItemInputFields',
                        'BtnId'=>$this->getChatsRepository()->findItemIdByChequeId($chat->getCurrentChequeId())
                    ]
                );
                $request->setCallbackData($callBackData);

                return $this->processRequest($request, Stage::GET_ITEM_INPUT_FIELDS, $isIntegrationTesting);
            }
        } catch (EmptyFetchResultException $e) {
            $message = new AnswerMessage($request->getMessage()->getChat()->getId());
            $message->setMessage('Не могу найти информацию о предыдущем действии, странно :(');
            return $message;
        }

        $message = new AnswerMessage($request->getMessage()->getChat()->getId());
        $message->setGoToStage(Stage::DEFAULT);
        return $message;
    }

    /**
     * @param string $facadeDiKey
     *
     * @return TelegramFacadeInterface
     *
     * @throws UnknownCommandException
     */
    private function getTGFacadeFromDI(string $facadeDiKey): TelegramFacadeInterface
    {
        try {
            $facade = $this->getServicesContainer()->get($facadeDiKey);
            if (!$facade instanceof TelegramFacadeInterface) {
                $this->getLogger()->critical(
                    'Wrong configuration! '.$facadeDiKey.' must be implemented by TelegramFacadeInterface',
                    ['tags' => ['error'], 'object' => $this]
                );
                throw new \LogicException(
                    'Wrong configuration! '.$facadeDiKey.' must be implemented by TelegramFacadeInterface'
                );
            }
            return $facade;
        } catch (\Exception $e) {
            $this->getLogger()->critical(
                'Wrong configuration! Class not found for '.$facadeDiKey.'.',
                ['tags' => ['error'],'object' => $this]
            );
            throw new UnknownCommandException('Class not found for '.$facadeDiKey);
        }
    }
}
