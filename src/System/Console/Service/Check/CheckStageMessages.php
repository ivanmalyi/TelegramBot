<?php

declare(strict_types=1);

namespace System\Console\Service\Check;

/**
 * Class CheckStageMessages
 * @package System\Console\Service\Check
 */
class CheckStageMessages
{
    const ANNUL = 1;
    const ANNULLING_AFTER_PAYMENT_CANCEL = 2;
    const COMPLETE = 3;
    const CANCELLING_AFTER_FUNDS_ANNUL = 4;
}
