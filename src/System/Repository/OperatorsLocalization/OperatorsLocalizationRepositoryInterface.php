<?php

declare(strict_types=1);

namespace System\Repository\OperatorsLocalization;
use System\Entity\Repository\OperatorLocalization;


/**
 * Interface OperatorsLocalizationRepositoryInterface
 * @package System\Repository\OperatorsLocalization
 */
interface OperatorsLocalizationRepositoryInterface
{
    public function clearOperatorsLocalization(): void;

    /**
     * @param OperatorLocalization[] $operatorsLocalization
     * @return int
     */
    public function saveOperatorsLocalization(array $operatorsLocalization): int;

}