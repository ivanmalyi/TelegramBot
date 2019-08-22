<?php

declare(strict_types=1);

namespace System\Repository\Commissions;

use System\Entity\Repository\Commission;

/**
 * Interface CommissionsRepositoryInterface
 * @package System\Repository\Commissions
 */
interface CommissionsRepositoryInterface
{
    /**
     * @return void
     */
    public function clearCommissions(): void;

    /**
     * @param Commission[] $commissions
     * @return int
     */
    public function saveCommissions(array $commissions): int;

    /**
     * @param int $itemId
     * @return Commission[]
     */
    public function findAllByItemId(int $itemId): array;

    /**
     * @param int $itemId
     * @param string $time
     *
     * @return Commission[]
     */
    public function findAllByItemIdAndTime(int $itemId, string $time): array;

    /**
     * @param int $chequeId
     *
     * @return Commission[]
     */
    public function findAllByChequeId(int $chequeId): array;
}