<?php

declare(strict_types=1);

namespace System\Exception\Provider;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class UnknownProviderException
 * @package System\Exception\Provider
 */
class UnknownProviderException extends ProviderException
{
    /**
     * UnknownProviderException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message, ResponseCode::UNKNOWN_PROVIDER);
    }
}
