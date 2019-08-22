<?php

declare(strict_types=1);

namespace System\Component\CreateCheque;


use System\Entity\Component\ChequeComponent;
use System\Entity\Repository\Payment;

/**
 * Interface CreateChequeComponentInterface
 * @package System\Component\GenerateCheque
 */
interface CreateChequeComponentInterface
{
    /**
     * @param Payment $payment
     * @return ChequeComponent
     */
    public function generateCheque(Payment $payment): ChequeComponent;
}