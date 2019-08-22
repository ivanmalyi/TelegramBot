<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol;

/**
 * Class StageMessageVariables
 * @package System\Entity\InternalProtocol
 */
class StageMessageVariables
{
    /**
     * @var string
     */
    private $fio;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $account;

    /**
     * @var int
     */
    private $billingChequeId;

    /**
     * @var float
     */
    private $toAmount;

    /**
     * @var float
     */
    private $fromAmount;

    /**
     * @var float
     */
    private $minAmount;

    /**
     * @var float
     */
    private $maxAmount;

    /**
     * @var float
     */
    private $totalAmount;

    /**
     * @var float
     */
    private $commission;

    /**
     * @var string
     */
    private $currentPhoneNumber;

    /**
     * StageMessageVariables constructor.
     */
    public function __construct()
    {
        $this->fio = '';
        $this->amount = 0.00;
        $this->account = '';
        $this->billingChequeId = 0;
        $this->toAmount = 0.00;
        $this->fromAmount = 0.00;
        $this->minAmount = 0.00;
        $this->maxAmount = 0.00;
        $this->totalAmount = 0;
        $this->commission = 0.00;
        $this->currentPhoneNumber = '';
    }

    /**
     * @return string
     */
    public function getFio(): string
    {
        return $this->fio;
    }

    /**
     * @param string $fio
     */
    public function setFio(string $fio): void
    {
        $this->fio = $fio;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getAccount(): string
    {
        return $this->account;
    }

    /**
     * @param string $account
     */
    public function setAccount(string $account): void
    {
        $this->account = $account;
    }

    /**
     * @return int
     */
    public function getBillingChequeId(): int
    {
        return $this->billingChequeId;
    }

    /**
     * @param int $billingChequeId
     */
    public function setBillingChequeId(int $billingChequeId): void
    {
        $this->billingChequeId = $billingChequeId;
    }

    /**
     * @return float
     */
    public function getToAmount(): float
    {
        return $this->toAmount;
    }

    /**
     * @param float $toAmount
     */
    public function setToAmount(float $toAmount): void
    {
        $this->toAmount = $toAmount;
    }

    /**
     * @return float
     */
    public function getFromAmount(): float
    {
        return $this->fromAmount;
    }

    /**
     * @param float $fromAmount
     */
    public function setFromAmount(float $fromAmount): void
    {
        $this->fromAmount = $fromAmount;
    }

    /**
     * @return float
     */
    public function getMinAmount(): float
    {
        return $this->minAmount;
    }

    /**
     * @param float $minAmount
     */
    public function setMinAmount(float $minAmount): void
    {
        $this->minAmount = $minAmount;
    }

    /**
     * @return float
     */
    public function getMaxAmount(): float
    {
        return $this->maxAmount;
    }

    /**
     * @param float $maxAmount
     */
    public function setMaxAmount(float $maxAmount): void
    {
        $this->maxAmount = $maxAmount;
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    /**
     * @param float $totalAmount
     */
    public function setTotalAmount(float $totalAmount): void
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * @return float
     */
    public function getCommission(): float
    {
        return $this->commission;
    }

    /**
     * @param float $commission
     */
    public function setCommission(float $commission): void
    {
        $this->commission = $commission;
    }

    /**
     * @return string
     */
    public function getCurrentPhoneNumber(): string
    {
        return $this->currentPhoneNumber;
    }

    /**
     * @param string $currentPhoneNumber
     */
    public function setCurrentPhoneNumber(string $currentPhoneNumber): void
    {
        $this->currentPhoneNumber = $currentPhoneNumber;
    }
}
