<?php

namespace System\Exception\Protocol;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class UnauthorizedException
 * @package System\Exception\Protocol
 */
class UnauthorizedException extends ProtocolException
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct('Wrong login or password', ResponseCode::AUTH_ERROR);
    }
}
