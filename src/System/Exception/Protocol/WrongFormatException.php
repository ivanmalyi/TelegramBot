<?php

declare(strict_types=1);

namespace System\Exception\Protocol;

use System\Entity\InternalProtocol\ResponseCode;

class WrongFormatException extends ProtocolException
{
    public function __construct($message)
    {
        parent::__construct($message, ResponseCode::WRONG_FORMAT);
    }
}
