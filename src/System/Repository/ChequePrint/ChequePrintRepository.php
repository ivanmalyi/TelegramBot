<?php

declare(strict_types=1);

namespace System\Repository\ChequePrint;


use System\Entity\Component\Billing\Response\ChequePrint;
use System\Repository\AbstractPdoRepository;

/**
 * Class ChequePrintRepository
 * @package System\Repository\ChequePrint
 */
class ChequePrintRepository extends AbstractPdoRepository implements ChequePrintRepositoryInterface
{
    /**
     * @param ChequePrint[] $chequesPrint
     * @param int $chequeId
     * @return int
     * @throws \System\Exception\DiException
     */
    public function saveChequesPrint(array $chequesPrint, int $chequeId): int
    {
        $sql =/**@lang text*/
            'insert into cheque_print (cheque_id, text, value, target) values ';
        $placeholders = [];
        foreach ($chequesPrint as $key=>$chequePrint) {
            $sql .="(:chequeId{$key}, :text{$key}, :value{$key}, :target{$key}),";
            $placeholders += [
                "chequeId{$key}"=>$chequeId,
                "text{$key}"=>$chequePrint->getText(),
                "value{$key}"=>$chequePrint->getValue(),
                "target{$key}"=>$chequePrint->getTarget(),
            ];
        }

        return $this->insert(rtrim($sql, ','), $placeholders);
    }

    /**
     * @param int $chequeId
     * @return ChequePrint[]
     */
    public function findChequesPrintByChequeId(int $chequeId): array
    {
        $sql = 'select id, cheque_id, text, value, target 
                from cheque_print
                where cheque_id = :chequeId';

        $rows = $this->execAssoc($sql, ['chequeId' => $chequeId]);

        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->inflate($row);
        }

        return $result;
    }

    /**
     * @param array $row
     * @return ChequePrint
     */
    private function inflate(array $row): ChequePrint
    {
        return new ChequePrint($row['text'], $row['value'], $row['target']);
    }

}