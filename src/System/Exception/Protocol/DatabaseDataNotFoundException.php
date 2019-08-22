<?php

declare(strict_types=1);

namespace System\Exception\Protocol;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class DataNotFoundException
 * @package System\Exception\Protocol
 */
class DatabaseDataNotFoundException extends ProtocolException
{
    /**
     * DataNotFoundException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message, ResponseCode::DATABASE_ERROR);
    }
}
