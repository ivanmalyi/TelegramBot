<?php

declare(strict_types=1);

namespace System\Repository\PaymentsPrintData;

use System\Entity\Repository\PaymentPrintData;

/**
 * Interface PaymentsPrintDataRepositoryInterface
 * @package System\Repository\PaymentsPrintData
 */
interface PaymentsPrintDataRepositoryInterface
{
    public function create(PaymentPrintData $data): int;
}
