<?php

declare(strict_types=1);

namespace System\Facade\TelegramAd;

use System\Entity\InternalProtocol\Request\UtmRequest;
use System\Entity\InternalProtocol\Response\TelegramAdResponse;

/**
 * Interface TelegramAdFacadeInterface
 * @package System\Facade\TelegramAd
 */
interface TelegramAdFacadeInterface
{
    /**
     * @param UtmRequest $request
     * @return TelegramAdResponse
     */
    public function process(UtmRequest $request): TelegramAdResponse;
}
