<?php

declare(strict_types=1);

namespace System\Action;

use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\Request\Telegram\CallbackRequest;
use System\Exception\DiException;
use System\Facade\TelegramCallbackFacadeInterface;
use System\Kernel\Protocol\RequestBundle;

/**
 * Class TelegramCallbackError
 * @package System\Action
 */
class TelegramCallbackError extends AbstractAction
{
    /**
     * @var TelegramCallbackFacadeInterface
     */
    private $telegramCallbackErrorFacade;

    /**
     * @return TelegramCallbackFacadeInterface
     * @throws DiException
     */
    public function getTelegramCallbackErrorFacade(): TelegramCallbackFacadeInterface
    {
        if ($this->telegramCallbackErrorFacade === null) {
            throw new DiException('TelegramCallbackErrorFacade');
        }
        return $this->telegramCallbackErrorFacade;
    }

    /**
     * @param TelegramCallbackFacadeInterface $telegramCallbackErrorFacade
     */
    public function setTelegramCallbackErrorFacade(TelegramCallbackFacadeInterface $telegramCallbackErrorFacade): void
    {
        $this->telegramCallbackErrorFacade = $telegramCallbackErrorFacade;
    }

    /**
     * @param RequestBundle $request
     *
     * @throws DiException
     * @throws \System\Exception\Protocol\MissingArgumentException
     * @throws \System\Exception\Protocol\ValidateArgumentException
     */
    public function handle(RequestBundle $request)
    {
        $telegramRequest = CallbackRequest::validation($request);
        $response = $this->getTelegramCallbackErrorFacade()->process($telegramRequest);

        $this->getPayBot()->sendUserMessage($response);
        $this->redirectToBotApp(ChatBotId::TELEGRAM);
    }
}
