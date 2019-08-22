<?php

declare(strict_types=1);

namespace System\Repository\ChequesCommissions;

use System\Entity\Repository\ChequeCommission;
use System\Repository\AbstractPdoRepository;

/**
 * Class ChequesCommissionsRepository
 * @package System\Repository\ChequesCommissions
 */
class ChequesCommissionsRepository extends AbstractPdoRepository implements ChequesCommissionsRepositoryInterface
{
    /**
     * @param ChequeCommission $chequeCommission
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function create(ChequeCommission $chequeCommission): int
    {
        $sql = 'insert into cheques_commissions (cheque_id, commission_id, item_id)
          VALUES (:chequeId, :commissionId, :itemId)';

        return $this->insert($sql, [
            'chequeId' => $chequeCommission->getChequeId(),
            'commissionId' => $chequeCommission->getCommissionId(),
            'itemId' => $chequeCommission->getItemId()
        ]);
    }
}
