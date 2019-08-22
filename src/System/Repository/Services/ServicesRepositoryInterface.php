<?php

declare(strict_types=1);

namespace System\Repository\Services;

use System\Entity\Repository\Service;

/**
 * Interface ServicesRepositoryInterface
 * @package System\Repository\Services
 */
interface ServicesRepositoryInterface
{
    /**
     * @return mixed
     */
    public function clearServices();

    /**
     * @param array $services
     *
     * @return int
     */
    public function saveServices(array $services): int;

    /**
     * @param int $operatorId
     *
     * @return Service[]
     */
    public function findAllByOperatorId(int $operatorId): array;

    /**
     * @return Service[]
     */
    public function findAllByItemOn(): array;

    /**
     * @param array $servicesId
     * @param int $status
     *
     * @return int
     */
    public function updateStatuses(array $servicesId, int $status): int;
}
