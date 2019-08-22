<?php

declare(strict_types=1);

namespace System\Entity\Repository;


class PaymentPurpose
{
    /**
     * @var int
     */
    private $itemId;

    /**
     * @var string
     */
    private $localization;

    /**
     * @var string
     */
    private $purpose;

    /**
     * @var int
     */
    private $id;

    /**
     * PaymentPurpose constructor.
     * @param int $itemId
     * @param string $localization
     * @param string $purpose
     * @param int $id
     */
    public function __construct(int $itemId, string $localization, string $purpose, int $id = 0)
    {
        $this->itemId = $itemId;
        $this->localization = $localization;
        $this->purpose = $purpose;
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
     * @return string
     */
    public function getLocalization(): string
    {
        return $this->localization;
    }

    /**
     * @return string
     */
    public function getPurpose(): string
    {
        return $this->purpose;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}