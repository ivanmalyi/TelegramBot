<?php

declare(strict_types=1);

namespace System\Exception\Protocol;


use System\Entity\InternalProtocol\ResponseCode;

class ItemsNotFoundException extends ProtocolException
{
    public function __construct()
    {
        parent::__construct("Items not found", ResponseCode::DATA_NOT_FOUND);
    }
}