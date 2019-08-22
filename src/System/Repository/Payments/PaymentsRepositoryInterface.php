<?php

declare(strict_types=1);

namespace System\Repository\Payments;

use System\Entity\Repository\BillingData;
use System\Entity\Repository\Payment;
use System\Exception\EmptyFetchResultException;

/**
 * Interface PaymentsRepositoryInterface
 * @package System\Repository\Payments
 */
interface PaymentsRepositoryInterface
{
    /**
     * @param int $chequeId
     * @return Payment
     *
     * @throws EmptyFetchResultException
     */
    public function findByChequeId(int $chequeId): Payment;

    /**
     * @param Payment $payment
     * @return int
     */
    public function create(Payment $payment): int;

    /**
     * @param array $statuses
     * @return Payment[]
     */
    public function findAllByStatuses(array $statuses): array;

    /**
     * @param BillingData $billingData
     * @return int
     */
    public function updateBillingData(BillingData $billingData): int;

    /**
     * @param int $status
     * @param int $id
     * @return int
     */
    public function updateStatus(int $status, int $id): int;
}