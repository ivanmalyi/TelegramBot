<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;

use System\Entity\Component\Billing\LocalizationData;

/**
 * Class AdditionalAccount
 * @package System\Entity\Component\Billing\Response
 */
class AdditionalAccount
{
    /**
     * @var LocalizationData[]
     */
    private $accountNames;

    /**
     * @var boolean
     */
    private $isRequired;

    /**
     * @var string
     */
    private $mask;

    /**
     * @var int
     */
    private $inputType;

    /**
     * @var int
     */
    private $order;

    /**
     * AdditionalAccount constructor.
     * @param LocalizationData[] $accountNames
     * @param bool $isRequired
     * @param string $mask
     * @param int $inputType
     * @param int $order
     */
    public function __construct(
        array $accountNames,
        bool $isRequired,
        string $mask,
        int $inputType,
        int $order
    )
    {
        $this->accountNames = $accountNames;
        $this->isRequired = $isRequired;
        $this->mask = $mask;
        $this->inputType = $inputType;
        $this->order = $order;
    }

    /**
     * @return LocalizationData[]
     */
    public function getAccountNames(): array
    {
        return $this->accountNames;
    }

    /**
     * @return boolean
     */
    public function isIsRequired(): bool
    {
        return $this->isRequired;
    }

    /**
     * @return string
     */
    public function getMask(): string
    {
        return $this->mask;
    }

    /**
     * @return int
     */
    public function getInputType(): int
    {
        return $this->inputType;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }
}
