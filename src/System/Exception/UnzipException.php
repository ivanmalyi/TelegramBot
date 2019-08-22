<?php

declare(strict_types=1);

namespace System\Exception;

use System\Entity\InternalProtocol\ResponseCode;
use System\Exception\Protocol\ProtocolException;


class UnzipException extends ProtocolException
{
    public function __construct()
    {
        parent::__construct("Unzip error", ResponseCode::UNZIP_ERROR);
    }
}
