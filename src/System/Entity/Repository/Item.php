<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class Item
 * @package System\Entity\Repository
 */
class Item
{
    /**
     * @var int
     */
    private $serviceId;

    /**
     * @var string
     */
    private $image;

    /**
     * @var int
     */
    private $minAmount;

    /**
     * @var int
     */
    private $maxAmount;

    /**
     * @var int
     */
    private $status;

    /**
     * @var int
     */
    private $mcc;

    /**
     * @var int
     */
    private $id;

    /**
     * Item constructor.
     * @param int $serviceId
     * @param string $image
     * @param int $minAmount
     * @param int $maxAmount
     * @param int $status
     * @param int $mcc
     * @param int $id
     */
    public function __construct(int $serviceId, string $image, int $minAmount, int $maxAmount, int $status, int $mcc, int $id = 0)
    {
        $this->serviceId = $serviceId;
        $this->image = $image;
        $this->minAmount = $minAmount;
        $this->maxAmount = $maxAmount;
        $this->status = $status;
        $this->id = $id;
        $this->mcc = $mcc;
    }

    /**
     * @return int
     */
    public function getServiceId(): int
    {
        return $this->serviceId;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @return int
     */
    public function getMinAmount(): int
    {
        return $this->minAmount;
    }

    /**
     * @return int
     */
    public function getMaxAmount(): int
    {
        return $this->maxAmount;
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
    public function getMcc(): int
    {
        return $this->mcc;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}