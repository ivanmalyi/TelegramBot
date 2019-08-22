<?php

declare(strict_types=1);

namespace System\Exception\Protocol;

/**
 * Class BadItemAmountException
 * @package System\Exception\Protocol
 */
class BadItemAmountException extends ProtocolException
{
    public function __construct(float $needsAmount,int $code)
    {
        parent::__construct((string) $needsAmount, $code);
    }
}
