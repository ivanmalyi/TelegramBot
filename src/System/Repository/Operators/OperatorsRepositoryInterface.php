<?php

declare(strict_types=1);

namespace System\Repository\Operators;


use System\Entity\Repository\Operator;
use System\Entity\Repository\OperatorLocalization;

/**
 * Interface OperatorsRepositoryInterface
 * @package System\Repository\Operators
 */
interface OperatorsRepositoryInterface
{
    /**
     * @return mixed
     */
    public function clearOperators();

    /**
     * @param Operator[] $operators
     * @return int
     */
    public function saveOperators(array $operators): int;

    /**
     * @param int $sectionId
     * @param string $localization
     * @return OperatorLocalization[]
     */
    public function findOperatorsBySectionId(int $sectionId, string $localization): array;

    /**
     * @return Operator[]
     */
    public function findAllByServiceOn(): array;

    /**
     * @param array $operatorsId
     * @param int $status
     *
     * @return int
     */
    public function updateStatuses(array $operatorsId, int $status): int;
}