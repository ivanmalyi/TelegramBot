<?php

declare(strict_types=1);

namespace System\Action;

use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\Request\Telegram\CallbackRequest;
use System\Exception\DiException;
use System\Facade\TelegramCallbackFacadeInterface;
use System\Kernel\Protocol\RequestBundle;

/**
 * Class TelegramCallback3ds
 * @package System\Action
 */
class TelegramCallback3ds extends AbstractAction
{
    /**
     * @var TelegramCallbackFacadeInterface
     */
    private $telegramCallback3dsFacade;

    /**
     * @return TelegramCallbackFacadeInterface
     * @throws DiException
     */
    public function getTelegramCallback3dsFacade(): TelegramCallbackFacadeInterface
    {
        if ($this->telegramCallback3dsFacade === null) {
            throw new DiException('TelegramCallback3dsFacade');
        }
        return $this->telegramCallback3dsFacade;
    }

    /**
     * @param TelegramCallbackFacadeInterface $telegramCallback3dsFacade
     */
    public function setTelegramCallback3dsFacade(TelegramCallbackFacadeInterface $telegramCallback3dsFacade): void
    {
        $this->telegramCallback3dsFacade = $telegramCallback3dsFacade;
    }

    /**
     * @param RequestBundle $request
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\Protocol\MissingArgumentException
     * @throws \System\Exception\Protocol\ValidateArgumentException
     */
    public function handle(RequestBundle $request)
    {
        $telegramRequest = CallbackRequest::validation($request);
        $response = $this->getTelegramCallback3dsFacade()->process($telegramRequest);

        $this->getPayBot()->sendUserMessage($response);
        $this->redirectToBotApp(ChatBotId::TELEGRAM);
    }
}
