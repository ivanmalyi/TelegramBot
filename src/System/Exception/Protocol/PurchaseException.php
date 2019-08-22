<?php

declare(strict_types=1);

namespace System\Exception\Protocol;

/**
 * Class PurchaseException
 * @package System\Exception\Protocol
 */
class PurchaseException extends ProtocolException
{
    /**
     * PurchaseException constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}
