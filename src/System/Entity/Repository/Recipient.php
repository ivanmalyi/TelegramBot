<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class Recipient
 * @package System\Entity\Repository
 */
class Recipient
{
    const TEMPLATE_ID = 1;

    /**
     * @var int
     */
    private $itemId;

    /**
     * @var int
     */
    private $templateId;

    /**
     * @var string
     */
    private $companyName;

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
     * Recipient constructor.
     * @param int $itemId
     * @param int $templateId
     * @param string $companyName
     * @param string $recipientCode
     * @param string $bankName
     * @param string $bankCode
     * @param string $checkingAccount
     * @param int $id
     */
    public function __construct(
        int $itemId,
        int $templateId,
        string $companyName,
        string $recipientCode,
        string $bankName,
        string $bankCode,
        string $checkingAccount,
        int $id = 0
    )
    {
        $this->itemId = $itemId;
        $this->templateId = $templateId;
        $this->companyName = $companyName;
        $this->recipientCode = $recipientCode;
        $this->bankName = $bankName;
        $this->bankCode = $bankCode;
        $this->checkingAccount = $checkingAccount;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getItemId(): int
    {
        return $this->itemId;
    }

    /**
     * @return int
     */
    public function getTemplateId(): int
    {
        return $this->templateId;
    }

    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
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
