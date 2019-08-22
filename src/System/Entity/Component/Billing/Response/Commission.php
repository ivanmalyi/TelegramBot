<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;

/**
 * Class Commission
 * @package System\Entity\Component\Billing\Response
 */
class Commission
{
    /**
     * @var int
     */
    private $commissionId;

    /**
     * @var int
     */
    private $itemId;

    /**
     * @var float
     */
    private $commision;

    /**
     * @var float
     */
    private $fromAmt;

    /**
     * @var float
     */
    private $toAmt;

    /**
     * @var float
     */
    private $minCommission;

    /**
     * @var float
     */
    private $maxCommission;

    /**
     * @var string
     */
    private $fromTime;

    /**
     * @var string
     */
    private $toTime;

    /**
     * @var float
     */
    private $round;

    /**
     * @var int
     */
    private $commissionType;

    /**
     * @var int
     */
    private $algorithm;

    /**
     * @var int
     */
    private $itemCommissionRound;

    /**
     * Commission constructor.
     * @param int $commissionId
     * @param int $itemId
     * @param float $commision
     * @param float $fromAmt
     * @param float $toAmt
     * @param float $minCommission
     * @param float $maxCommission
     * @param string $fromTime
     * @param string $toTime
     * @param float $round
     * @param int $commissionType
     * @param int $algorithm
     * @param int $itemCommissionRound
     */
    public function __construct(
        int $commissionId,
        int $itemId,
        float $commision,
        float $fromAmt,
        float $toAmt,
        float $minCommission,
        float $maxCommission,
        string $fromTime,
        string $toTime,
        float $round,
        int $commissionType = 0,
        int $algorithm = 0,
        int $itemCommissionRound = 0
    ) {
        $this->commissionId = $commissionId;
        $this->itemId = $itemId;
        $this->commision = $commision;
        $this->fromAmt = $fromAmt;
        $this->toAmt = $toAmt;
        $this->minCommission = $minCommission;
        $this->maxCommission = $maxCommission;
        $this->fromTime = $fromTime;
        $this->toTime = $toTime;
        $this->round = $round;
        $this->commissionType = $commissionType;
        $this->algorithm = $algorithm;
        $this->itemCommissionRound = $itemCommissionRound;
    }

    /**
     * @return int
     */
    public function getCommissionId() : int
    {
        return $this->commissionId;
    }

    /**
     * @return int
     */
    public function getItemId() : int
    {
        return $this->itemId;
    }

    /**
     * @return float
     */
    public function getCommision() : float
    {
        return $this->commision;
    }

    /**
     * @return float
     */
    public function getFromAmt() : float
    {
        return $this->fromAmt;
    }

    /**
     * @return float
     */
    public function getToAmt() : float
    {
        return $this->toAmt;
    }

    /**
     * @return float
     */
    public function getMinCommission() : float
    {
        return $this->minCommission;
    }

    /**
     * @return float
     */
    public function getMaxCommission() : float
    {
        return $this->maxCommission;
    }

    /**
     * @return string
     */
    public function getFromTime() : string
    {
        return $this->fromTime;
    }

    /**
     * @return string
     */
    public function getToTime() : string
    {
        return $this->toTime;
    }

    /**
     * @return float
     */
    public function getRound() : float
    {
        return $this->round;
    }

    /**
     * @param float $round
     */
    public function setRound(float $round)
    {
        $this->round = $round;
    }

    /**
     * @return int
     */
    public function getCommissionType() : int
    {
        return $this->commissionType;
    }

    /**
     * @param int $commissionType
     */
    public function setCommissionType(int $commissionType)
    {
        $this->commissionType = $commissionType;
    }

    /**
     * @return int
     */
    public function getAlgorithm() : int
    {
        return $this->algorithm;
    }

    /**
     * @param int $algorithm
     */
    public function setAlgorithm(int $algorithm)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * @return int
     */
    public function getItemCommissionRound(): int
    {
        return $this->itemCommissionRound;
    }
}
