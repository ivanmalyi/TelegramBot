<?php

declare(strict_types=1);

namespace System\Repository\Payments;

use System\Entity\Repository\BillingData;
use System\Entity\Repository\Payment;
use System\Exception\EmptyFetchResultException;
use System\Repository\AbstractPdoRepository;

/**
 * Class PaymentsRepository
 * @package System\Repository\Payments
 */
class PaymentsRepository extends AbstractPdoRepository implements PaymentsRepositoryInterface
{
    /**
     * @param int $chequeId
     * @return Payment
     *
     * @throws EmptyFetchResultException
     */
    public function findByChequeId(int $chequeId): Payment
    {
       $sql = 'select id, cheque_id, item_id, account, amount, commission, status, billing_cheque_id,
           billing_payment_id, created_at, updated_at, billing_status, acquiring_status, acquiring_transaction_id,
           acquiring_merchant_id, acquiring_confirm_url, ps_id, billing_operator_pay_id, billing_operator_cheque_id,
           chat_history_id
        from payments
        where cheque_id=:chequeId';

       $row = $this->execAssocOne($sql, ['chequeId' => $chequeId]);
       return $this->inflate($row);
    }

    /**
     * @param array $row
     * @return Payment
     */
    private function inflate(array $row): Payment
    {
        return new Payment(
            (int) $row['cheque_id'],
            (int) $row['item_id'],
            explode(';',$row['account']),
            (int) $row['amount'],
            (int) $row['commission'],
            (int) $row['status'],
            (int) $row['billing_cheque_id'],
            (int) $row['billing_payment_id'],
            $row['created_at'],
            $row['updated_at'],
            (int) $row['billing_status'],
            (int) $row['acquiring_status'],
            (int) $row['acquiring_transaction_id'],
            $row['acquiring_merchant_id'],
            $row['acquiring_confirm_url'],
            (int) $row['ps_id'],
            (int) $row['billing_operator_pay_id'],
            (int) $row['billing_operator_cheque_id'],
            (int) $row['chat_history_id'],
            (int) $row['id']
        );
    }

    /**
     * @param Payment $payment
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function create(Payment $payment): int
    {
        $sql = 'insert into payments (cheque_id, item_id, account, amount, commission, status, billing_cheque_id,
           billing_payment_id, created_at, updated_at, billing_status, acquiring_status, acquiring_transaction_id,
           acquiring_merchant_id, acquiring_confirm_url, ps_id, billing_operator_pay_id, billing_operator_cheque_id,
           chat_history_id)
          values (:chequeId, :itemId, :account, :amount, :commission, :status, :billingChequeId,
           :billingPaymentId, :createdAt, :updatedAt, :billingStatus, :acquiringStatus, :acquiringTransactionId,
           :acquiringMerchantId, :acquiringConfirmUrl, :psId, :billingOperatorPayId, :billingOperatorChequeId,
           :chatHistoryId)';

        return $this->insert($sql, [
            'chequeId' => $payment->getChequeId(),
            'itemId' => $payment->getItemId(),
            'account' => implode(';',$payment->getAccount()),
            'amount' => $payment->getAmount(),
            'commission' => $payment->getCommission(),
            'status' => $payment->getStatus(),
            'billingChequeId' => $payment->getBillingChequeId(),
            'billingPaymentId' => $payment->getBillingPaymentId(),
            'createdAt' => $payment->getCreatedAt(),
            'updatedAt' => $payment->getUpdatedAt(),
            'billingStatus' => $payment->getBillingStatus(),
            'acquiringStatus' => $payment->getAcquiringStatus(),
            'acquiringTransactionId' => $payment->getAcquiringTransactionId(),
            'acquiringMerchantId' => $payment->getAcquiringMerchantId(),
            'acquiringConfirmUrl' => $payment->getAcquiringConfirmUrl(),
            'psId' => $payment->getPsId(),
            'billingOperatorPayId' => $payment->getBillingOperatorPayId(),
            'billingOperatorChequeId' => $payment->getBillingOperatorChequeId(),
            'chatHistoryId' => $payment->getChatHistoryId()
        ]);
    }

    /**
     * @param array $statuses
     * @return Payment[]
     */
    public function findAllByStatuses(array $statuses): array
    {
        if (empty($statuses)) {
            return [];
        }
        $sql = 'select id, cheque_id, item_id, account, amount, commission, status, billing_cheque_id,
           billing_payment_id, created_at, updated_at, billing_status, acquiring_status, acquiring_transaction_id,
           acquiring_merchant_id, acquiring_confirm_url, ps_id, billing_operator_pay_id, billing_operator_cheque_id,
           chat_history_id
        from payments
        where status in ('.implode(',', $statuses).')';

        $rows = $this->execAssoc($sql, []);
        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->inflate($row);
        }
        return $result;
    }

    /**
     * @param BillingData $billingData
     * @return int
     */
    public function updateBillingData(BillingData $billingData): int
    {
        $sql = 'update payments
          set billing_payment_id=:billingPaymentId, updated_at=now(), billing_status=:billingStatus,
            billing_operator_pay_id=:billingOperatorPayId, billing_operator_cheque_id=:billingOperatorChequeId,
            acquiring_status=:acquiringStatus, acquiring_confirm_url=:acquiringConfirmUrl,
            acquiring_merchant_id=:acquiringMerchantId, acquiring_transaction_id=:acquiringTransactionId,
            ps_id=:psId
          where id=:id';

        return $this->update($sql, [
            'billingPaymentId' => $billingData->getBillingPaymentId(),
            'id' => $billingData->getId(),
            'billingStatus' => $billingData->getBillingStatus(),
            'billingOperatorPayId' => $billingData->getBillingOperatorPayId(),
            'billingOperatorChequeId' => $billingData->getBillingOperatorChequeId(),
            'acquiringStatus' => $billingData->getAcquiringStatus(),
            'acquiringConfirmUrl' => $billingData->getAcquiringConfirmUrl(),
            'acquiringMerchantId' => $billingData->getAcquiringMerchantId(),
            'acquiringTransactionId' => $billingData->getAcquiringTransactionId(),
            'psId' => $billingData->getPsId()
        ]);
    }

    /**
     * @param int $status
     * @param int $id
     * @return int
     */
    public function updateStatus(int $status, int $id): int
    {
        $sql = 'update payments set status=:status, updated_at=now() where id=:id';

        return $this->update($sql, ['status' => $status, 'id' => $id]);
    }
}