<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing;

/**
 * Class BillingAcquiringStatus
 * @package System\Entity\Component\Billing
 */
class BillingAcquiringStatus
{
    const CANCEL = -19;
    const SECURE_3D = 20;
    const WAITING = 25;
    const HOLD = 26;
    const COMPLETE = 28;
}
