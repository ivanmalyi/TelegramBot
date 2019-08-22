<?php

declare(strict_types=1);

namespace System\Facade;

use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Kernel\Protocol\AnswerMessage;

/**
 * Interface TelegramFacadeInterface
 * @package System\Facade
 */
interface TelegramFacadeInterface
{
    /**
     * @param TelegramRequest $request
     * @return AnswerMessage
     */
    public function process(TelegramRequest $request): AnswerMessage;
}
