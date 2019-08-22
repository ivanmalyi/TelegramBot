<?php

declare(strict_types=1);

namespace System\Repository\Commissions;


use System\Entity\Repository\Commission;
use System\Repository\AbstractPdoRepository;

/**
 * Class CommissionsRepository
 * @package System\Repository\Commissions
 */
class CommissionsRepository extends AbstractPdoRepository implements CommissionsRepositoryInterface
{
    public function clearCommissions(): void
    {
        $sql = 'truncate table commissions';
        $this->update($sql, []);
    }

    /**
     * @param Commission[] $commissions
     * @return int
     * @throws \System\Exception\DiException
     */
    public function saveCommissions(array $commissions): int
    {
        $sql =/**@lang tetx*/
            'insert ignore into commissions(id, item_id, commission_type, amount, algorithm, from_amount, to_amount, 
                                     min_amount, max_amount, from_time, to_time, round) 
             values ';
        $placeholders = [];
        foreach ($commissions as $key=>$commission) {
            $sql .="(:id{$key}, :itemId{$key}, :commissionType{$key}, :amount{$key}, :algorithm{$key}, :fromAmount{$key},
                    :toAmount{$key}, :minAmount{$key}, :maxAmount{$key}, :fromTime{$key}, :toTime{$key}, :round{$key}),";
            $placeholders += [
                "id{$key}"=>$commission->getId(),
                "itemId{$key}"=>$commission->getItemId(),
                "commissionType{$key}"=>$commission->getCommissionType(),
                "amount{$key}"=>$commission->getAmount(),
                "algorithm{$key}"=>$commission->getAlgorithm(),
                "fromAmount{$key}"=>$commission->getFromAmount(),
                "toAmount{$key}"=>$commission->getToAmount(),
                "minAmount{$key}"=>$commission->getMinAmount(),
                "maxAmount{$key}"=>$commission->getMaxAmount(),
                "fromTime{$key}"=>$commission->getFromTime(),
                "toTime{$key}"=>$commission->getToTime(),
                "round{$key}"=>$commission->getRound()
            ];
        }

        return $this->insert(rtrim($sql, ','), $placeholders);
    }

    /**
     * @param int $itemId
     * @return Commission[]
     */
    public function findAllByItemId(int $itemId): array
    {
        $sql = 'select id, item_id, commission_type, amount, algorithm, from_amount, to_amount, 
            min_amount, max_amount, from_time, to_time, round
        from commissions
        where item_id=:itemId';

        $rows = $this->execAssoc($sql, ['itemId' => $itemId]);
        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->inflate($row);
        }
        return $result;
    }

    private function inflate(array $row): Commission
    {
        return new Commission(
            (int) $row['item_id'],
            (int) $row['commission_type'],
            (int) $row['amount'],
            (int) $row['algorithm'],
            (int) $row['from_amount'],
            (int) $row['to_amount'],
            (int) $row['min_amount'],
            (int) $row['max_amount'],
            $row['from_time'],
            $row['to_time'],
            (int) $row['round'],
            (int) $row['id']
        );
    }

    /**
     * @param int $itemId
     * @param string $time
     *
     * @return Commission[]
     */
    public function findAllByItemIdAndTime(int $itemId, string $time): array
    {
        $sql = 'select id, item_id, commission_type, amount, algorithm, from_amount, to_amount, 
            min_amount, max_amount, from_time, to_time, round
        from commissions
        where item_id=:itemId and from_time <= :currentTime and :currentTime < to_time';

        $rows = $this->execAssoc($sql, ['itemId' => $itemId, 'currentTime' => $time]);
        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->inflate($row);
        }
        return $result;
    }

    /**
     * @param int $chequeId
     *
     * @return Commission[]
     */
    public function findAllByChequeId(int $chequeId): array
    {
        $sql = 'select c.id, c.item_id, commission_type, amount, algorithm, from_amount, to_amount, 
            min_amount, max_amount, from_time, to_time, round
        from cheques_commissions as cc
          join commissions as c on cc.commission_id=c.id and cc.item_id=c.item_id 
        where cc.cheque_id=:chequeId';

        $rows = $this->execAssoc($sql, ['chequeId' => $chequeId]);
        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->inflate($row);
        }
        return $result;
    }
}
