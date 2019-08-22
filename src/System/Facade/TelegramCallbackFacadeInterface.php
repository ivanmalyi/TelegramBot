<?php

declare(strict_types=1);

namespace System\Facade;

use System\Entity\InternalProtocol\Request\Telegram\CallbackRequest;
use System\Kernel\Protocol\AnswerMessage;

/**
 * Interface TelegramCallbackErrorFacadeInterface
 * @package System\Facade\TelegramCallbackError
 */
interface TelegramCallbackFacadeInterface
{
    /**
     * @param CallbackRequest $request
     * @return AnswerMessage
     */
    public function process(CallbackRequest $request): AnswerMessage;
}
