<?php

declare(strict_types=1);

namespace System\Repository\Cheques;

use System\Entity\Repository\Cheque;
use System\Exception\EmptyFetchResultException;
use System\Repository\AbstractPdoRepository;

/**
 * Class ChequesRepository
 * @package System\Repository\Cheques
 */
class ChequesRepository extends AbstractPdoRepository implements ChequesRepositoryInterface
{
    /**
     * @param array $row
     * @return Cheque
     */
    private function inflate(array $row): Cheque
    {
        return new Cheque(
            (int) $row['chat_id'],
            (int) $row['user_id'],
            explode(';', $row['account']),
            (int) $row['item_id'],
            (int) $row['amount'],
            (int) $row['status'],
            (int) $row['billing_cheque_id'],
            (int) $row['commission'],
            (int) $row['payment_system_id'],
            (int) $row['id']
        );
    }

    /**
     * @param Cheque $cheque
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function create(Cheque $cheque): int
    {
        $sql = 'insert into cheques (chat_id, user_id, account, item_id, amount, status, billing_cheque_id, commission)
          values (:chatId, :userId, :account, :itemId, :amount, :status, :billingChequeId, :commission)';

        return $this->insert($sql, [
            'chatId' => $cheque->getChatId(),
            'userId' => $cheque->getUserId(),
            'account' => implode(';', $cheque->getAccount()),
            'itemId' => $cheque->getItemId(),
            'amount' => $cheque->getAmount(),
            'status' => $cheque->getStatus(),
            'billingChequeId' => $cheque->getBillingChequeId(),
            'commission' => $cheque->getCommission()
        ]);
    }

    /**
     * @param Cheque $cheque
     * @return int
     */
    public function updateCheque(Cheque $cheque): int
    {
        $sql = 'update cheques set';

        $sqlParams = [];
        $params = ['chequeId' => $cheque->getId()];

        if (!empty($cheque->getAccount())) {
            $sqlParams[] = 'account=:account';
            $params['account'] = implode(';', $cheque->getAccount());
        }
        if ($cheque->getAmount() !== 0) {
            $sqlParams[] = 'amount=:amount';
            $params['amount'] = $cheque->getAmount();
        }
        if ($cheque->getCommission() !== 0) {
            $sqlParams[] = 'commission=:commission';
            $params['commission'] = $cheque->getCommission();
        }
        if ($cheque->getStatus() !== 0) {
            $sqlParams[] = 'status=:status';
            $params['status'] = $cheque->getStatus();
        }
        if ($cheque->getBillingChequeId() !== 0) {
            $sqlParams[] = 'billing_cheque_id=:billingChequeId';
            $params['billingChequeId'] = $cheque->getBillingChequeId();
        }
        if ($cheque->getItemId() !== 0) {
            $sqlParams[] = 'item_id=:itemId';
            $params['itemId'] = $cheque->getItemId();
        }

        if ($cheque->getPaymentSystemId() !== 0) {
            $sqlParams[] = 'payment_system_id=:paymentSystemId';
            $params['paymentSystemId'] = $cheque->getPaymentSystemId();
        }

        $sql .= ' ' . implode(', ', $sqlParams);
        $sql .= ' where id = :chequeId';

        return $this->update($sql, $params);
    }

    /**
     * @param int $chequeId
     *
     * @return Cheque
     *
     * @throws EmptyFetchResultException
     */
    public function findById(int $chequeId): Cheque
    {
        $sql = 'select id, chat_id, user_id, account, item_id, amount, status, billing_cheque_id, commission, payment_system_id
            from cheques
            where id=:chequeId';

        $row = $this->execAssocOne($sql, ['chequeId' => $chequeId]);

        return $this->inflate($row);
    }
}
