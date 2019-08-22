<?php

declare(strict_types=1);

namespace System\Action;

use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\Request\Telegram\CallbackRequest;
use System\Exception\DiException;
use System\Facade\TelegramCallbackFacadeInterface;
use System\Kernel\Protocol\RequestBundle;

/**
 * Class TelegramCallback
 * @package System\Action
 */
class TelegramCallbackOk extends AbstractAction
{
    /**
     * @var TelegramCallbackFacadeInterface
     */
    private $telegramCallbackOkFacade;

    /**
     * @return TelegramCallbackFacadeInterface
     *
     * @throws DiException
     */
    public function getTelegramCallbackOkFacade(): TelegramCallbackFacadeInterface
    {
        if ($this->telegramCallbackOkFacade === null) {
            throw new DiException('TelegramCallbackOkFacade');
        }
        return $this->telegramCallbackOkFacade;
    }

    /**
     * @param TelegramCallbackFacadeInterface $telegramCallbackOkFacade
     */
    public function setTelegramCallbackOkFacade(TelegramCallbackFacadeInterface $telegramCallbackOkFacade): void
    {
        $this->telegramCallbackOkFacade = $telegramCallbackOkFacade;
    }

    /**
     * @param RequestBundle $request
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\Protocol\MissingArgumentException
     * @throws \System\Exception\Protocol\ValidateArgumentException
     */
    public function handle(RequestBundle $request): void
    {
        $telegramRequest = CallbackRequest::validation($request);
        $response = $this->getTelegramCallbackOkFacade()->process($telegramRequest);

        $this->getPayBot()->sendUserMessage($response);
        $this->redirectToBotApp(ChatBotId::TELEGRAM);
    }
}
