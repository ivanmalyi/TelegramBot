<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class Display
 * @package System\Entity\Repository
 */
class Display
{
    /**
     * @var int
     */
    private $chequeId;

    /**
     * @var int
     */
    private $billingPayAmount;

    /**
     * @var int
     */
    private $billingMaxPayAmount;

    /**
     * @var int
     */
    private $billingMinPayAmount;

    /**
     * @var bool
     */
    private $isModifyPayAmount;

    /**
     * @var string
     */
    private $recipient;

    /**
     * @var string
     */
    private $recipientCode;

    /**
     * @var string
     */
    private $bankName;

    /**
     * @var string
     */
    private $bankCode;

    /**
     * @var string
     */
    private $checkingAccount;

    /**
     * @var int
     */
    private $id;

    /**
     * Display constructor.
     * @param int $chequeId
     * @param int $billingPayAmount
     * @param int $billingMaxPayAmount
     * @param int $billingMinPayAmount
     * @param bool $isModifyPayAmount
     * @param string $recipient
     * @param string $recipientCode
     * @param string $bankName
     * @param string $bankCode
     * @param string $checkingAccount
     * @param int $id
     */
    public function __construct(
        int $chequeId,
        int $billingPayAmount,
        int $billingMaxPayAmount,
        int $billingMinPayAmount,
        bool $isModifyPayAmount,
        string $recipient,
        string $recipientCode,
        string $bankName,
        string $bankCode,
        string $checkingAccount,
        int $id = 0
    )
    {
        $this->chequeId = $chequeId;
        $this->billingPayAmount = $billingPayAmount;
        $this->billingMaxPayAmount = $billingMaxPayAmount;
        $this->billingMinPayAmount = $billingMinPayAmount;
        $this->isModifyPayAmount = $isModifyPayAmount;
        $this->recipient = $recipient;
        $this->recipientCode = $recipientCode;
        $this->bankName = $bankName;
        $this->bankCode = $bankCode;
        $this->checkingAccount = $checkingAccount;
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
    public function getBillingPayAmount(): int
    {
        return $this->billingPayAmount;
    }

    /**
     * @return int
     */
    public function getBillingMaxPayAmount(): int
    {
        return $this->billingMaxPayAmount;
    }

    /**
     * @return int
     */
    public function getBillingMinPayAmount(): int
    {
        return $this->billingMinPayAmount;
    }

    /**
     * @return bool
     */
    public function isModifyPayAmount(): bool
    {
        return $this->isModifyPayAmount;
    }

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * @return string
     */
    public function getRecipientCode(): string
    {
        return $this->recipientCode;
    }

    /**
     * @return string
     */
    public function getBankName(): string
    {
        return $this->bankName;
    }

    /**
     * @return string
     */
    public function getBankCode(): string
    {
        return $this->bankCode;
    }

    /**
     * @return string
     */
    public function getCheckingAccount(): string
    {
        return $this->checkingAccount;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}