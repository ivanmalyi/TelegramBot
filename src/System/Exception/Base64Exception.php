<?php

declare(strict_types=1);

namespace System\Exception;

use System\Entity\InternalProtocol\ResponseCode;
use System\Exception\Protocol\ProtocolException;

class Base64Exception extends ProtocolException
{
    public function __construct()
    {
        parent::__construct("Bad base64 string", ResponseCode::WRONG_FORMAT);
    }
}
