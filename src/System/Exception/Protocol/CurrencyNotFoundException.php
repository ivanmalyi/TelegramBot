<?php

declare(strict_types=1);

namespace System\Exception\Protocol;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class CurrencyNotFoundException
 * @package System\Exception\Protocol
 */
class CurrencyNotFoundException extends ProtocolException
{
    /**
     * CurrencyNotFoundException constructor.
     * @param string $currency
     */
    public function __construct($currency)
    {
        parent::__construct('Currency '.$currency.' is not supported', ResponseCode::INVALID_ARGUMENT);
    }
}
