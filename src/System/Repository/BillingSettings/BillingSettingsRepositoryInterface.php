<?php

declare(strict_types=1);

namespace System\Repository\BillingSettings;

use System\Entity\Repository\BillingSettings;

/**
 * Interface BillingSettingsRepositoryInterface
 * @package System\Repository\BillingSettings
 */
interface BillingSettingsRepositoryInterface
{
    /**
     * @return BillingSettings
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findParams(): BillingSettings;

    /**
     * @param string $publicKey
     * @param string $privateKey
     * @return int
     */
    public function updateKeys(string $publicKey, string $privateKey): int;
}