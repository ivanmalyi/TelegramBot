<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class Cheque
 * @package System\Entity\Repository
 */
class Cheque
{
    const NEW = 0;
    const OK = 21;
    const PROVIDER_ERROR = -40;
    const ACCOUNT_NOT_FOUND = -35;
    const ACCOUNT_BANNED = -34;
    const CUSTOM_ANSWER = -41;
    const NOT_PROVIDER = -45;

    const EXACT_AMOUNT = -50;

    /**
     * @var int
     */
    private $chatId;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var array
     */
    private $account;

    /**
     * @var int
     */
    private $itemId;

    /**
     * @var int
     */
    private $amount;

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
    private $commission;

    /**
     * @var int
     */
    private $paymentSystemId;

    /**
     * @var int
     */
    private $id;

    /**
     * Cheque constructor.
     * @param int $chatId
     * @param int $userId
     * @param array $account
     * @param int $itemId
     * @param int $amount
     * @param int $status
     * @param int $billingChequeId
     * @param int $commission
     * @param int $paymentSystemId
     * @param int $id
     */
    public function __construct(
        int $chatId,
        int $userId,
        array $account,
        int $itemId,
        int $amount,
        int $status,
        int $billingChequeId,
        int $commission,
        int $paymentSystemId = 1,
        int $id = 0
    )
    {
        $this->chatId = $chatId;
        $this->userId = $userId;
        $this->account = $account;
        $this->itemId = $itemId;
        $this->amount = $amount;
        $this->status = $status;
        $this->billingChequeId = $billingChequeId;
        $this->commission = $commission;
        $this->paymentSystemId = $paymentSystemId;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chatId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return array
     */
    public function getAccount(): array
    {
        return $this->account;
    }

    /**
     * @param array $account
     */
    public function setAccount(array $account): void
    {
        $this->account = $account;
    }

    /**
     * @return int
     */
    public function getItemId(): int
    {
        return $this->itemId;
    }

    /**
     * @param int $itemId
     */
    public function setItemId(int $itemId): void
    {
        $this->itemId = $itemId;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
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
     * @return int
     */
    public function getCommission(): int
    {
        return $this->commission;
    }

    /**
     * @param int $commission
     */
    public function setCommission(int $commission): void
    {
        $this->commission = $commission;
    }

    /**
     * @return int
     */
    public function getPaymentSystemId(): int
    {
        return $this->paymentSystemId;
    }

    /**
     * @param int $paymentSystemId
     */
    public function setPaymentSystemId(int $paymentSystemId): void
    {
        $this->paymentSystemId = $paymentSystemId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
