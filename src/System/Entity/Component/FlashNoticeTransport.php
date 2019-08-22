<?php

declare(strict_types=1);

namespace System\Entity\Component;

/**
 * Class FlashNoticeTransport
 * @package System\Entity\Component
 */
class FlashNoticeTransport
{
    const EMAIL = 1;
    const TELEGRAM = 2;
    const REDIS_EVENT = 3;
}
