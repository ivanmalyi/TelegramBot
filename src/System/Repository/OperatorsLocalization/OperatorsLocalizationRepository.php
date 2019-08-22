<?php

declare(strict_types=1);

namespace System\Repository\OperatorsLocalization;


use System\Entity\Repository\OperatorLocalization;
use System\Repository\AbstractPdoRepository;

/**
 * Class OperatorsLocalizationRepository
 * @package System\Repository\OperatorsLocalization
 */
class OperatorsLocalizationRepository extends AbstractPdoRepository implements OperatorsLocalizationRepositoryInterface
{
    public function clearOperatorsLocalization(): void
    {
        $sql = 'truncate table operators_localization';
        $this->update($sql, []);
    }


    /**
     * @param OperatorLocalization[] $operatorsLocalization
     * @return int
     * @throws \System\Exception\DiException
     */
    public function saveOperatorsLocalization(array $operatorsLocalization): int
    {
        $sql =/**@lang text*/
            'insert into operators_localization (operator_id, localization, name, description) values  ';
        $placeholders = [];
        foreach ($operatorsLocalization as $key=>$operatorLocalization) {
            $sql .="(:operatorId{$key}, :localization{$key}, :name{$key}, :description{$key}),";
            $placeholders += [
                "operatorId{$key}"=>$operatorLocalization->getOperatorId(),
                "localization{$key}"=>$operatorLocalization->getLocalization(),
                "name{$key}"=>$operatorLocalization->getName(),
                "description{$key}"=>$operatorLocalization->getDescription()
            ];
        }

        return $this->insert(rtrim($sql, ','), $placeholders);
    }
}