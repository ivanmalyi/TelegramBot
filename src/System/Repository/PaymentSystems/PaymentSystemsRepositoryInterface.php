<?php

declare(strict_types=1);

namespace System\Repository\PaymentSystems;

use System\Entity\Repository\PaymentSystem;

/**
 * Interface PaymentSystemsRepositoryInterface
 * @package System\Repository\PaymentSystems
 */
interface PaymentSystemsRepositoryInterface
{
    /**
     * @param PaymentSystem $paymentSystem
     * @return int
     */
    public function save(PaymentSystem $paymentSystem): int;

    /**
     * @param PaymentSystem[] $paymentSystems
     * @return int
     */
    public function saveAll(array $paymentSystems): int;

    /**
     * @return int
     */
    public function deleteAll(): int;
}
