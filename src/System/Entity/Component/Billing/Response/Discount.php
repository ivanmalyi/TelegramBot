<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;

/**
 * Class Discount
 * @package System\Entity\Component\Billing\Response
 */
class Discount
{
    const ALL = 0;
    const CACHE = 1;
    const CARD = 2;

    /**
     * @var float
     */
    private $coefficient;

    /**
     * @var int
     */
    private $fundsType;

    /**
     * Discount constructor.
     * @param float $coefficient
     * @param int $fundsType
     */
    public function __construct(float $coefficient, int $fundsType)
    {
        $this->coefficient = $coefficient;
        $this->fundsType = $fundsType;
    }

    /**
     * @return float
     */
    public function getCoefficient(): float
    {
        return $this->coefficient;
    }

    /**
     * @return int
     */
    public function getFundsType(): int
    {
        return $this->fundsType;
    }
}
