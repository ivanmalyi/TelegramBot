<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;


/**
 * Class AcquiringCommission
 * @package System\Entity\Component\Billing\Response
 */
class AcquiringCommission
{
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
     * AcquiringCommission constructor.
     * @param int $amount
     * @param int $algorithm
     * @param int $fromAmount
     * @param int $toAmount
     * @param int $minAmount
     * @param int $maxAmount
     */
    public function __construct(
        int $amount,
        int $algorithm,
        int $fromAmount,
        int $toAmount,
        int $minAmount,
        int $maxAmount
    )
    {
        $this->amount = $amount;
        $this->algorithm = $algorithm;
        $this->fromAmount = $fromAmount;
        $this->toAmount = $toAmount;
        $this->minAmount = $minAmount;
        $this->maxAmount = $maxAmount;
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
}