<?php

declare(strict_types=1);

namespace System\Repository\Display;


use System\Entity\Component\Billing\Display as VerifyDisplay;
use System\Entity\Repository\Display;
use System\Repository\AbstractPdoRepository;

/**
 * Class DisplayRepository
 * @package System\Repository\Display
 */
class DisplayRepository extends AbstractPdoRepository implements DisplayRepositoryInterface
{
    /**
     * @param VerifyDisplay $verifyDisplay
     * @param int $chequeId
     * @return int
     * @throws \System\Exception\DiException
     */
    public function saveDisplay(VerifyDisplay $verifyDisplay, int $chequeId): int
    {
        $sql = 'insert into display(cheque_id, billing_pay_amount, billing_max_pay_amount, billing_min_pay_amount, 
                                    is_modify_pay_amount, recipient, recipient_code, bank_name, bank_code, checking_account) 
                value (:chequeId, :billingPayAmount, :billingMaxPayAmount, :billingMinPayAmount, :isModifyPayAmount,
                      :recipient, :recipientCode, :bankName, :bankCode, :chekingAccount)';

        $placeholders = [
            'chequeId'=>$chequeId,
            'billingPayAmount'=>$verifyDisplay->getPayAmount(),
            'billingMaxPayAmount'=>$verifyDisplay->getMaxPayAmount(),
            'billingMinPayAmount'=>$verifyDisplay->getMinPayAmount(),
            'isModifyPayAmount'=>$verifyDisplay->isModifyPayAmount() === true ? 1: 0,
            'recipient'=>$verifyDisplay->getRecipient(),
            'recipientCode'=>$verifyDisplay->getRecipientCode(),
            'bankName'=>$verifyDisplay->getBankName(),
            'bankCode'=>$verifyDisplay->getBankCode(),
            'chekingAccount'=>$verifyDisplay->getCheckingAccount()
        ];

        return $this->insert($sql, $placeholders);
    }

    public function findDisplayByChequeId(int $chequeId): Display
    {
        $sql = 'select id, cheque_id, billing_pay_amount, billing_max_pay_amount, billing_min_pay_amount, 
                       is_modify_pay_amount, recipient, recipient_code, bank_name, bank_code, checking_account 
               from display 
               where cheque_id = :chequeId';
        $placeholders = [
            'chequeId'=>$chequeId
        ];

        $row = $this->execAssocOne($sql, $placeholders);

        return $this->inflate($row);
    }

    /**
     * @param array $row
     * @return Display
     */
    private function inflate(array $row): Display
    {
        return new Display(
            (int)$row['cheque_id'],
            (int)$row['billing_pay_amount'],
            (int)$row['billing_max_pay_amount'],
            (int)$row['billing_min_pay_amount'],
            (int)$row['is_modify_pay_amount'] == 1 ? true: false,
            $row['recipient'],
            $row['recipient_code'],
            $row['bank_name'],
            $row['bank_code'],
            $row['checking_account'],
            (int)$row['id']
        );
    }
}