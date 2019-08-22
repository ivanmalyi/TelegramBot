<?php

declare(strict_types=1);

namespace System\Repository\Cheques;

use System\Entity\Repository\Cheque;
use System\Exception\EmptyFetchResultException;

/**
 * Interface ChequesRepositoryInterface
 * @package System\Repository\Cheques
 */
interface ChequesRepositoryInterface
{
    /**
     * @param Cheque $cheque
     *
     * @return int
     */
    public function create(Cheque $cheque): int;

    /**
     * @param Cheque $cheque
     * @return int
     */
    public function updateCheque(Cheque $cheque): int;

    /**
     * @param int $chequeId
     *
     * @return Cheque
     *
     * @throws EmptyFetchResultException
     */
    public function findById(int $chequeId): Cheque;
}
