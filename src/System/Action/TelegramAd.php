<?php

declare(strict_types=1);

namespace System\Action;

use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\Request\UtmRequest;
use System\Exception\DiException;
use System\Facade\TelegramAd\TelegramAdFacadeInterface;
use System\Kernel\Protocol\RequestBundle;

/**
 * Class TelegramAd
 * @package System\Action
 */
class TelegramAd extends AbstractAction
{
    /**
     * @var TelegramAdFacadeInterface
     */
    private $telegramAdFacade;

    /**
     * @return TelegramAdFacadeInterface
     * @throws DiException
     */
    public function getTelegramAdFacade(): TelegramAdFacadeInterface
    {
        if ($this->telegramAdFacade === null) {
            throw new DiException('TelegramAdFacade');
        }
        return $this->telegramAdFacade;
    }

    /**
     * @param TelegramAdFacadeInterface $telegramAdFacade
     */
    public function setTelegramAdFacade(TelegramAdFacadeInterface $telegramAdFacade): void
    {
        $this->telegramAdFacade = $telegramAdFacade;
    }

    /**
     * @param RequestBundle $request
     *
     * @return void
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\Protocol\MissingArgumentException
     * @throws \System\Exception\Protocol\ValidateArgumentException
     */
    public function handle(RequestBundle $request)
    {
        $request = UtmRequest::validation($request);
        $response = $this->getTelegramAdFacade()->process($request);

        $this->redirectToBotApp(ChatBotId::TELEGRAM, $response->getGuid());
    }
}
