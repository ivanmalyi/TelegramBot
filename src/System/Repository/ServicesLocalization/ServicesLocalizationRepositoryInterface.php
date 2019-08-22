<?php

declare(strict_types=1);

namespace System\Repository\ServicesLocalization;


use System\Entity\Repository\ServiceLocalization;


/**
 * Interface ServicesLocalizationRepositoryInterface
 * @package System\Repository\ServicesLocalization
 */
interface ServicesLocalizationRepositoryInterface
{
    /**
     * @return void
     */
    public function clearServicesLocalization(): void;

    /**
     * @param ServiceLocalization[] $servicesLocalization
     * @return int
     */
    public function saveServicesLocalization(array $servicesLocalization): int;

    /**
     * @param int $serviceId
     * @param string $localization
     *
     * @return ServiceLocalization
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findByServiceIdAndLocalization(int $serviceId, string $localization): ServiceLocalization;
}