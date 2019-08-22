<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol;

/**
 * Class Currency
 * @package System\Entity\InternalProtocol
 */
class Currency
{
    const UAH = 'UAH';
    const EUR = 'EUR';
    const USD = 'USD';

    /**
     * @param float $payAmount
     * @return int
     */
    public static function uahToKopeck(float $payAmount): int
    {
        return (int) round($payAmount * 100);
    }

    /**
     * @param int $kopeck
     * @return float
     */
    public static function kopeckToUah(int $kopeck): float
    {
        return round(($kopeck / 100), 2);
    }
}
