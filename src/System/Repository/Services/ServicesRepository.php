<?php

declare(strict_types=1);

namespace System\Repository\Services;

use System\Entity\Repository\Service;
use System\Repository\AbstractPdoRepository;

/**
 * Class ServicesRepository
 * @package System\Repository\Services
 */
class ServicesRepository extends AbstractPdoRepository implements ServicesRepositoryInterface
{
    /**
     * @return mixed|void
     */
    public function clearServices()
    {
        $sql = 'truncate table services';
        $this->update($sql, []);
    }

    /**
     * @param Service[] $services
     * @return int
     * @throws \System\Exception\DiException
     */
    public function saveServices(array $services): int
    {
        $sql =/**@lang text*/
            'insert into services(id, operator_id, service_type_id, image, status) values ';
        $placeholders = [];
        foreach ($services as $key=>$service) {
            $sql .="(:id{$key}, :operatorId{$key}, :serviceTypeId{$key}, :image{$key}, :status{$key}),";
            $placeholders += [
                "id{$key}"=>$service->getId(),
                "operatorId{$key}"=>$service->getOperatorId(),
                "serviceTypeId{$key}"=>$service->getServiceTypeId(),
                "image{$key}"=>$service->getImage(),
                "status{$key}"=>$service->getStatus(),
            ];
        }

        return $this->insert(rtrim($sql, ','), $placeholders);
    }

    /**
     * @param int $operatorId
     * @return Service[]
     */
    public function findAllByOperatorId(int $operatorId): array
    {
        $sql = 'select id, operator_id, service_type_id, image, status
          from services
          where operator_id=:operatorId and status=1';

        $rows = $this->execAssoc($sql, ['operatorId' => $operatorId]);

        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->inflate($row);
        }

        return $result;
    }

    /**
     * @param array $row
     * @return Service
     */
    private function inflate(array $row): Service
    {
        return new Service(
            (int) $row['operator_id'],
            (int) $row['service_type_id'],
            $row['image'],
            (int) $row['status'],
            (int) $row['id']
        );
    }

    /**
     * @return Service[]
     */
    public function findAllByItemOn(): array
    {
        $sql = 'select s.id, s.operator_id, s.service_type_id, s.image, s.status
                from services as s
                left join items as i on i.service_id = s.id
                where i.status = 1';

        $rows = $this->execAssoc($sql, []);

        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->inflate($row);
        }

        return $result;
    }

    /**
     * @param array $servicesId
     * @param int $status
     *
     * @return int
     */
    public function updateStatuses(array $servicesId, int $status): int
    {
        $servicesId = implode(',', $servicesId);
        $sql = "update services
                set status = :status
                where id not in ({$servicesId})";

        return $this->update($sql, ['status'=>$status]);
    }
}