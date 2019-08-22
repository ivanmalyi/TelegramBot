<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class RecipientForCheque
 * @package System\Entity\Repository
 */
class RecipientForCheque
{
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
     * @var string
     */
    private $name;

    /**
     * RecipientForCheque constructor.
     * @param int $templateId
     * @param string $companyName
     * @param string $recipientCode
     * @param string $bankName
     * @param string $bankCode
     * @param string $checkingAccount
     * @param string $name
     */
    public function __construct(
        int $templateId, 
        string $companyName, 
        string $recipientCode, 
        string $bankName, 
        string $bankCode, 
        string $checkingAccount, 
        string $name
    )
    {
        $this->templateId = $templateId;
        $this->companyName = $companyName;
        $this->recipientCode = $recipientCode;
        $this->bankName = $bankName;
        $this->bankCode = $bankCode;
        $this->checkingAccount = $checkingAccount;
        $this->name = $name;
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}