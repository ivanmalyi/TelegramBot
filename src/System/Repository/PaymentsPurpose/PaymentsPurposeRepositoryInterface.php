<?php

declare(strict_types=1);

namespace System\Repository\PaymentsPurpose;

use System\Entity\Repository\PaymentPurpose;
use System\Exception\EmptyFetchResultException;


/**
 * Interface PaymentsPurposeRepositoryInterface
 * @package System\Repository\PaymentsPurpose
 */
interface PaymentsPurposeRepositoryInterface
{
    /**
     * @param PaymentPurpose[] $paymentsPurpose
     *
     * @return int
     */
    public function savePaymentsPurpose(array $paymentsPurpose): int;

    /**
     * @param int $itemId
     * @param string $localization
     *
     * @return PaymentPurpose
     *
     * @throws EmptyFetchResultException
     */
    public function findPaymentPurpose(int $itemId, string $localization): PaymentPurpose;

    public function clearTable(): void;
}