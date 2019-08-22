<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing;


use System\Util\ConverterClass\ToArrayTrait;

/**
 * Class Display
 * @package System\Entity\Component\Billing
 */
/**
 * Class Display
 * @package System\Entity\Component\Billing
 */
class Display
{
    use ToArrayTrait;

    /**
     * @var string
     */
    private $text;

    /**
     * @var int
     */
    private $payAmount;

    /**
     * @var int
     */
    private $maxPayAmount;

    /**
     * @var int
     */
    private $minPayAmount;

    /**
     * @var boolean
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
     * Display constructor.
     * @param string $text
     * @param int $payAmount
     * @param int $maxPayAmount
     * @param int $minPayAmount
     * @param bool $isModifyPayAmount
     * @param string $recipient
     * @param string $recipientCode
     * @param string $bankName
     * @param string $bankCode
     * @param string $checkingAccount
     */
    public function __construct(
        string $text = '',
        int $payAmount = 0,
        int $maxPayAmount = 0,
        int $minPayAmount = 0,
        bool $isModifyPayAmount = true,
        string $recipient = '',
        string $recipientCode = '',
        string $bankName = '',
        string $bankCode = '',
        string $checkingAccount = ''
    )
    {
        $this->text = $text;
        $this->payAmount = $payAmount;
        $this->maxPayAmount = $maxPayAmount;
        $this->minPayAmount = $minPayAmount;
        $this->isModifyPayAmount = $isModifyPayAmount;
        $this->recipient = $recipient;
        $this->recipientCode = $recipientCode;
        $this->bankName = $bankName;
        $this->bankCode = $bankCode;
        $this->checkingAccount = $checkingAccount;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getPayAmount(): int
    {
        return $this->payAmount;
    }

    /**
     * @return int
     */
    public function getMaxPayAmount(): int
    {
        return $this->maxPayAmount;
    }

    /**
     * @return int
     */
    public function getMinPayAmount(): int
    {
        return $this->minPayAmount;
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
}