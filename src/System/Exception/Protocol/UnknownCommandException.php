<?php

declare(strict_types=1);

namespace System\Exception\Protocol;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class UnknownCommandException
 * @package System\Exception\Protocol
 */
class UnknownCommandException extends ProtocolException
{
    /**
     * UnknownCommandException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message, ResponseCode::UNKNOWN_COMMAND);
    }
}
