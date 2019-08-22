<?php

declare(strict_types=1);

namespace System\Console\Command\DownloadKeys;

use System\Exception\DiException;
use System\Repository\BillingSettings\BillingSettingsRepositoryInterface;

/**
 * Trait DownloadKeysCommandDependenciesTrait
 * @package System\Console\DownloadKeys
 */
trait DownloadKeysCommandDependenciesTrait
{
    /**
     * @var BillingSettingsRepositoryInterface
     */
    private $billingSettingsRepository;

    /**
     * @return BillingSettingsRepositoryInterface
     * @throws DiException
     */
    public function getBillingSettingsRepository(): BillingSettingsRepositoryInterface
    {
        if (null === $this->billingSettingsRepository) {
            throw new DiException('BillingSettingsRepositorys');
        }

        return $this->billingSettingsRepository;
    }

    /**
     * @param BillingSettingsRepositoryInterface $billingSettingsRepository
     */
    public function setBillingSettingsRepository(BillingSettingsRepositoryInterface $billingSettingsRepository): void
    {
        $this->billingSettingsRepository = $billingSettingsRepository;
    }
}
