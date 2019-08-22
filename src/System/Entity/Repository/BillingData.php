<?php

declare(strict_types=1);

namespace System\Entity\Repository;

class BillingData
{
    /**
     * @var int
     */
    private $billingStatus;

    /**
     * @var int
     */
    private $billingChequeId;

    /**
     * @var int
     */
    private $billingPaymentId;

    /**
     * @var int
     */
    private $acquiringStatus;

    /**
     * @var string
     */
    private $acquiringConfirmUrl;

    /**
     * @var int
     */
    private $acquiringTransactionId;

    /**
     * @var string
     */
    private $acquiringMerchantId;

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
    private $id;

    /**
     * BillingData constructor.
     * @param int $billingStatus
     * @param int $billingChequeId
     * @param int $billingPaymentId
     * @param int $acquiringStatus
     * @param string $acquiringConfirmUrl
     * @param int $acquiringTransactionId
     * @param string $acquiringMerchantId
     * @param int $psId
     * @param int $billingOperatorPayId
     * @param int $billingOperatorChequeId
     * @param int $id
     */
    public function __construct(
        int $billingStatus,
        int $billingChequeId,
        int $billingPaymentId,
        int $acquiringStatus,
        string $acquiringConfirmUrl,
        int $acquiringTransactionId,
        string $acquiringMerchantId,
        int $psId,
        int $billingOperatorPayId,
        int $billingOperatorChequeId,
        int $id = 0
    )
    {
        $this->billingStatus = $billingStatus;
        $this->billingChequeId = $billingChequeId;
        $this->billingPaymentId = $billingPaymentId;
        $this->acquiringStatus = $acquiringStatus;
        $this->acquiringConfirmUrl = $acquiringConfirmUrl;
        $this->acquiringTransactionId = $acquiringTransactionId;
        $this->acquiringMerchantId = $acquiringMerchantId;
        $this->psId = $psId;
        $this->billingOperatorPayId = $billingOperatorPayId;
        $this->billingOperatorChequeId = $billingOperatorChequeId;
        $this->id = $id;
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
     * @return int
     */
    public function getAcquiringStatus(): int
    {
        return $this->acquiringStatus;
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
    public function getId(): int
    {
        return $this->id;
    }
}
