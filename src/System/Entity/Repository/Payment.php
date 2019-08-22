<?php

declare(strict_types=1);

namespace System\Entity\Repository;


use System\Util\ConverterClass\ToStringTrait;

/**
 * Class Payment
 * @package System\Entity\Repository
 */
class Payment
{
    use ToStringTrait;

    const CANCEL = -13;
    const NEW = -5;
    const WAITING = -1;
    const HOLD = 1;
    const OK_PROVIDER_PAYMENT = 5;
    const COMPLETE = 9;
    const CHEQUE_ISSUED = 10;

    /**
     * @var int
     */
    private $chequeId;

    /**
     * @var int
     */
    private $itemId;

    /**
     * @var array
     */
    private $account;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var int
     */
    private $commission;

    /**
     * @var int
     */
    private $status;

    /**
     * @var int
     */
    private $billingChequeId;

    /**
     * @var int
     */
    private $billingPaymentId;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $updatedAt;

    /**
     * @var int
     */
    private $billingStatus;

    /**
     * @var int
     */
    private $acquiringStatus;

    /**
     * @var int
     */
    private $acquiringTransactionId;

    /**
     * @var string
     */
    private $acquiringMerchantId;

    /**
     * @var string
     */
    private $acquiringConfirmUrl;

    /**
     * @var int
     */
    private $psId;

    /**
     * @var int
     */
    private $billingOperatorPayId;

    /**
     * @var int
     */
    private $billingOperatorChequeId;

    /**
     * @var int
     */
    private $chatHistoryId;

    /**
     * @var int
     */
    private $id;

    /**
     * Payment constructor.
     * @param int $chequeId
     * @param int $itemId
     * @param array $account
     * @param int $amount
     * @param int $commission
     * @param int $status
     * @param int $billingChequeId
     * @param int $billingPaymentId
     * @param string $createdAt
     * @param string $updatedAt
     * @param int $billingStatus
     * @param int $acquiringStatus
     * @param int $acquiringTransactionId
     * @param string $acquiringMerchantId
     * @param string $acquiringConfirmUrl
     * @param int $psId
     * @param int $billingOperatorPayId
     * @param int $billingOperatorChequeId
     * @param int $chatHistoryId
     * @param int $id
     */
    public function __construct(
        int $chequeId,
        int $itemId,
        array $account,
        int $amount,
        int $commission,
        int $status,
        int $billingChequeId,
        int $billingPaymentId,
        string $createdAt,
        string $updatedAt,
        int $billingStatus,
        int $acquiringStatus,
        int $acquiringTransactionId,
        string $acquiringMerchantId,
        string $acquiringConfirmUrl,
        int $psId,
        int $billingOperatorPayId,
        int $billingOperatorChequeId,
        int $chatHistoryId,
        int $id = 0
    )
    {
        $this->chequeId = $chequeId;
        $this->itemId = $itemId;
        $this->account = $account;
        $this->amount = $amount;
        $this->commission = $commission;
        $this->status = $status;
        $this->billingChequeId = $billingChequeId;
        $this->billingPaymentId = $billingPaymentId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->billingStatus = $billingStatus;
        $this->acquiringStatus = $acquiringStatus;
        $this->acquiringTransactionId = $acquiringTransactionId;
        $this->acquiringMerchantId = $acquiringMerchantId;
        $this->acquiringConfirmUrl = $acquiringConfirmUrl;
        $this->psId = $psId;
        $this->billingOperatorPayId = $billingOperatorPayId;
        $this->billingOperatorChequeId = $billingOperatorChequeId;
        $this->chatHistoryId = $chatHistoryId;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getChequeId(): int
    {
        return $this->chequeId;
    }

    /**
     * @return int
     */
    public function getItemId(): int
    {
        return $this->itemId;
    }

    /**
     * @return array
     */
    public function getAccount(): array
    {
        return $this->account;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getCommission(): int
    {
        return $this->commission;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getBillingChequeId(): int
    {
        return $this->billingChequeId;
    }

    /**
     * @return int
     */
    public function getBillingPaymentId(): int
    {
        return $this->billingPaymentId;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @return int
     */
    public function getBillingStatus(): int
    {
        return $this->billingStatus;
    }

    /**
     * @return int
     */
    public function getAcquiringStatus(): int
    {
        return $this->acquiringStatus;
    }

    /**
     * @return int
     */
    public function getAcquiringTransactionId(): int
    {
        return $this->acquiringTransactionId;
    }

    /**
     * @return string
     */
    public function getAcquiringMerchantId(): string
    {
        return $this->acquiringMerchantId;
    }

    /**
     * @return string
     */
    public function getAcquiringConfirmUrl(): string
    {
        return $this->acquiringConfirmUrl;
    }

    /**
     * @return int
     */
    public function getPsId(): int
    {
        return $this->psId;
    }

    /**
     * @return int
     */
    public function getBillingOperatorPayId(): int
    {
        return $this->billingOperatorPayId;
    }

    /**
     * @return int
     */
    public function getBillingOperatorChequeId(): int
    {
        return $this->billingOperatorChequeId;
    }

    /**
     * @return int
     */
    public function getChatHistoryId(): int
    {
        return $this->chatHistoryId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}