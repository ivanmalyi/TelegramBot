<?php

declare(strict_types=1);

namespace System\Repository\ServicesLocalization;


use System\Entity\Repository\ServiceLocalization;
use System\Repository\AbstractPdoRepository;

/**
 * Class ServicesLocalizationRepository
 * @package System\Repository\ServicesLocalization
 */
class ServicesLocalizationRepository extends AbstractPdoRepository implements ServicesLocalizationRepositoryInterface
{
    /**
     *
     */
    public function clearServicesLocalization(): void
    {
        $sql = 'truncate table services_localization';
        $this->update($sql, []);
    }

    /**
     * @param ServiceLocalization[] $servicesLocalization
     * @return int
     * @throws \System\Exception\DiException
     */
    public function saveServicesLocalization(array $servicesLocalization): int
    {
        $sql =/**@lang text*/
            'insert into services_localization (service_id, localization, name) values ';
        $placeholders = [];
        foreach ($servicesLocalization as $key=>$serviceLocalization) {
            $sql .="(:serviceId{$key}, :localization{$key}, :name{$key}),";
            $placeholders += [
                "serviceId{$key}"=>$serviceLocalization->getServiceId(),
                "localization{$key}"=>$serviceLocalization->getLocalization(),
                "name{$key}"=>$serviceLocalization->getName()
            ];
        }

        return $this->insert(rtrim($sql, ','), $placeholders);
    }

    /**
     * @param int $serviceId
     * @param string $localization
     *
     * @return ServiceLocalization
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findByServiceIdAndLocalization(int $serviceId, string $localization): ServiceLocalization
    {
        $sql = 'select sl.id, sl.service_id, sl.localization, sl.name
          from services_localization as sl
          left join services as s on s.id = sl.service_id
          where sl.service_id=:serviceId and sl.localization=:loc and s.status = 1';

        $row = $this->execAssocOne($sql, ['serviceId' => $serviceId, 'loc' => $localization]);

        return $this->inflate($row);
    }

    /**
     * @param array $row
     * @return ServiceLocalization
     */
    private function inflate(array $row): ServiceLocalization
    {
        return new ServiceLocalization(
            (int) $row['service_id'],
            $row['localization'],
            $row['name'],
            (int) $row['id']
        );
    }
}