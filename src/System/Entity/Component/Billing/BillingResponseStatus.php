<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing;

class BillingResponseStatus
{
    const ALREADY_CONDUCTED = -27;
    const INSUFFICIENT_AMOUNT = -25;
    const TEMPORARY_ERROR = -20;
    const CANCEL = -19;
    const PREPARE_CANCEL_FOR_PROVIDER_MODULE = -60;
    const WAITING = 25;
    const OK = 27;
}
