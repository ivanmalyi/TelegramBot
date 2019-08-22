<?php

declare(strict_types=1);

namespace System\Repository\ChequesCommissions;

use System\Entity\Repository\ChequeCommission;

/**
 * Interface ChequesCommissionsRepositoryInterface
 * @package System\Repository\ChequesCommissions
 */
interface ChequesCommissionsRepositoryInterface
{
    /**
     * @param ChequeCommission $chequeCommission
     * @return int
     */
    public function create(ChequeCommission $chequeCommission): int;
}
