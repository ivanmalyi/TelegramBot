<?php

declare(strict_types=1);

namespace System\Repository\ChequesText;


use System\Repository\AbstractPdoRepository;

class ChequesTextRepository extends AbstractPdoRepository implements ChequesTextRepositoryInterface
{
    /**
     * @param string $text
     * @param int $chequeId
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function saveChequeText(string $text, int $chequeId): int
    {
        $sql = 'insert into cheques_text (cheque_id, text) 
                value (:chequeId, :text)';

        return $this->insert($sql, [
            'chequeId' => $chequeId,
            'text' => $text
        ]);
    }
}