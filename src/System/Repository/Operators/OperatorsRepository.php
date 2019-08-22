<?php

declare(strict_types=1);

namespace System\Repository\Operators;


use System\Entity\Repository\Operator;
use System\Entity\Repository\OperatorLocalization;
use System\Repository\AbstractPdoRepository;

/**
 * Class OperatorsRepository
 * @package System\Repository\Operators
 */
class OperatorsRepository extends AbstractPdoRepository implements OperatorsRepositoryInterface
{
    /**
     *
     */
    public function clearOperators()
    {
        $sql = 'truncate table operators';
        $this->update($sql, []);
    }

    /**
     * @param Operator[] $operators
     * @return int
     * @throws \System\Exception\DiException
     */
    public function saveOperators(array $operators): int
    {
        $sql =/**@lang text*/
            'insert into operators (id, section_id, image, status) values ';
        $placeholders = [];
        foreach ($operators as $key=>$operator) {
            $sql .="(:id{$key}, :sectionId{$key}, :image{$key}, :status{$key}),";
            $placeholders += [
                "id{$key}"=>$operator->getId(),
                "sectionId{$key}"=>$operator->getSectionId(),
                "image{$key}"=>$operator->getImage(),
                "status{$key}"=>$operator->getStatus(),
            ];
        }

        return $this->insert(rtrim($sql, ','), $placeholders);
    }

    /**
     * @param int $sectionId
     * @param string $localization
     * @return OperatorLocalization[]
     */
    public function findOperatorsBySectionId(int $sectionId, string $localization): array
    {
        $sql = 'select ol.id, ol.operator_id, ol.localization, ol.name, ol.description
                from operators as o
                left join operators_localization as ol on ol.operator_id = o.id
                where o.section_id = :sectionId and ol.localization = :localization and o.status = 1';

        $rows = $this->execAssoc($sql, ['sectionId'=>$sectionId, 'localization'=>$localization]);

        $operatorsLocalization = [];
        foreach ($rows as $row) {
            $operatorsLocalization[] = $this->inflateOperatorLocalization($row);
        }
        return  $operatorsLocalization;
    }

    /**
     * @param array $row
     * @return OperatorLocalization
     */
    private function inflateOperatorLocalization(array $row): OperatorLocalization
    {
        return new OperatorLocalization(
            (int)$row['operator_id'],
            $row['localization'],
            $row['name'],
            $row['description'],
            (int)$row['id']
        );
    }

    /**
     * @return Operator[]
     */
    public function findAllByServiceOn(): array
    {
        $sql = 'select o.id, o.section_id, o.image, o.status
                from operators as o
                left join services as s on s.operator_id = o.id
                where s.status = 1';

        $rows = $this->execAssoc($sql, []);

        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->inflate($row);
        }

        return $result;
    }

    /**
     * @param array $row
     *
     * @return Operator
     */
    private function inflate(array $row): Operator
    {
        return new Operator(
            (int)$row['section_id'],
            $row['image'],
            (int)$row['status'],
            (int)$row['id']
        );
    }

    /**
     * @param array $operatorsId
     * @param int $status
     *
     * @return int
     */
    public function updateStatuses(array $operatorsId, int $status): int
    {
        $operatorsId = implode(',', $operatorsId);
        $sql = "update operators
                set status = :status
                where id not in ({$operatorsId})";

        return $this->update($sql, ['status'=>$status]);
    }
}