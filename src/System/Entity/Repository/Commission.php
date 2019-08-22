<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class Commission
 * @package System\Entity\Repository
 */
class Commission
{
    /**
     * @var int
     */
    private $itemId;

    /**
     * @var int
     */
    private $commissionType;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var int
     */
    private $algorithm;

    /**
     * @var int
     */
    private $fromAmount;

    /**
     * @var int
     */
    private $toAmount;

    /**
     * @var int
     */
    private $minAmount;

    /**
     * @var int
     */
    private $maxAmount;

    /**
     * @var string
     */
    private $fromTime;

    /**
     * @var string
     */
    private $toTime;

    /**
     * @var int
     */
    private $round;

    /**
     * @var int
     */
    private $id;

    /**
     * Commission constructor.
     * @param int $itemId
     * @param int $commissionType
     * @param int $amount
     * @param int $algorithm
     * @param int $fromAmount
     * @param int $toAmount
     * @param int $minAmount
     * @param int $maxAmount
     * @param string $fromTime
     * @param string $toTime
     * @param int $round
     * @param int $id
     */
    public function __construct(
        int $itemId,
        int $commissionType,
        int $amount,
        int $algorithm,
        int $fromAmount,
        int $toAmount,
        int $minAmount,
        int $maxAmount,
        string $fromTime,
        string $toTime,
        int $round,
        int $id = 0
    )
    {
        $this->itemId = $itemId;
        $this->commissionType = $commissionType;
        $this->amount = $amount;
        $this->algorithm = $algorithm;
        $this->fromAmount = $fromAmount;
        $this->toAmount = $toAmount;
        $this->minAmount = $minAmount;
        $this->maxAmount = $maxAmount;
        $this->fromTime = $fromTime;
        $this->toTime = $toTime;
        $this->round = $round;
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
    public function getCommissionType(): int
    {
        return $this->commissionType;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getAlgorithm(): int
    {
        return $this->algorithm;
    }

    /**
     * @return int
     */
    public function getFromAmount(): int
    {
        return $this->fromAmount;
    }

    /**
     * @return int
     */
    public function getToAmount(): int
    {
        return $this->toAmount;
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
     * @return string
     */
    public function getFromTime(): string
    {
        return $this->fromTime;
    }

    /**
     * @return string
     */
    public function getToTime(): string
    {
        return $this->toTime;
    }

    /**
     * @return int
     */
    public function getRound(): int
    {
        return $this->round;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}