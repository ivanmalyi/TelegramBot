<?php

declare(strict_types=1);

namespace System\Repository\ChequePrint;


use System\Entity\Component\Billing\Response\ChequePrint;

/**
 * Interface ChequePrintRepositoryInterface
 * @package System\Repository\ChequePrint
 */
interface ChequePrintRepositoryInterface
{
    /**
     * @param ChequePrint[]
     * @param int $chequeId
     * @return int
     */
    public function saveChequesPrint(array $chequesPrint, int $chequeId): int;

    /**
     * @param int $chequeId
     * @return ChequePrint[]
     */
    public function findChequesPrintByChequeId(int $chequeId): array;
}