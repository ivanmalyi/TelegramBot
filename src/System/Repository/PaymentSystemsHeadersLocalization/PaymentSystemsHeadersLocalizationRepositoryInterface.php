<?php

declare(strict_types=1);

namespace System\Repository\PaymentSystemsHeadersLocalization;

use System\Entity\Repository\PaymentSystemHeaderLocalization;

/**
 * Interface PaymentSystemsLocalizationRepositoryInterface
 * @package System\Repository\PaymentSystemsHeadersLocalization
 */
interface PaymentSystemsHeadersLocalizationRepositoryInterface
{
    /**
     * @param PaymentSystemHeaderLocalization $paymentSystemLocalization
     * @return int
     */
    public function save(PaymentSystemHeaderLocalization $paymentSystemLocalization): int;

    /**
     * @param PaymentSystemHeaderLocalization[] $paymentSystemLocalization
     * @return int
     */
    public function saveAll(array $paymentSystemLocalization): int;

    /**
     * @return int
     */
    public function deleteAll(): int;

    /**
     * @param int $paymentSystemId
     * @param string $localization
     *
     * @return PaymentSystemHeaderLocalization
     */
    public function findPaymentSystemById(int $paymentSystemId, string $localization): PaymentSystemHeaderLocalization;
}
