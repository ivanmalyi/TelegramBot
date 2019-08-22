<?php

declare(strict_types=1);

namespace System\Repository\AcquiringCommission;


use System\Entity\Component\Billing\Response\AcquiringCommission;
use System\Repository\AbstractPdoRepository;

/**
 * Class AcquiringCommissionRepository
 * @package System\Repository\AcquiringCommission
 */
class AcquiringCommissionRepository extends AbstractPdoRepository implements AcquiringCommissionRepositoryInterface
{

    /**
     * @param AcquiringCommission[] $acquiringCommissions
     * @param int $chequeId
     * @return int
     * @throws \System\Exception\DiException
     */
    public function saveAcquiringCommissions(array $acquiringCommissions, int $chequeId): int
    {
        $sql =/**@lang text*/
            'insert into acquiring_commission (cheque_id, amount, algorithm, from_amount, to_amount, min_amount, max_amount)
             values ';
        $placeholders = [];
        foreach ($acquiringCommissions as $key=>$acquiringCommission) {
            $sql .="(:chequeId{$key}, :amount{$key}, :algorithm{$key}, :fromAmount{$key}, :toAmount{$key}, 
                :minAmount{$key}, :maxAmount{$key}),";
            $placeholders += [
                "chequeId{$key}"=>$chequeId,
                "amount{$key}"=>$acquiringCommission->getAmount(),
                "algorithm{$key}"=>$acquiringCommission->getAlgorithm(),
                "fromAmount{$key}"=>$acquiringCommission->getFromAmount(),
                "toAmount{$key}"=>$acquiringCommission->getToAmount(),
                "minAmount{$key}"=>$acquiringCommission->getMinAmount(),
                "maxAmount{$key}"=>$acquiringCommission->getMaxAmount(),
            ];
        }

        return $this->insert(rtrim($sql, ','), $placeholders);
    }
}