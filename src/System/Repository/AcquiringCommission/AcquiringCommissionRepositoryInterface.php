<?php

declare(strict_types=1);

namespace System\Repository\AcquiringCommission;


/**
 * Interface AcquiringCommissionRepositoryInterface
 * @package System\Repository\AcquiringCommission
 */
interface AcquiringCommissionRepositoryInterface
{
    /**
     * @param array $acquiringCommissions
     * @param int $chequeId
     * @return int
     */
    public function saveAcquiringCommissions(array $acquiringCommissions, int $chequeId): int;
}