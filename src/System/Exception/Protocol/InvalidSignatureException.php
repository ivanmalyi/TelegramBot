<?php

namespace System\Exception\Protocol;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class InvalidSignatureException
 * @package System\Exception\Protocol
 */
class InvalidSignatureException extends ProtocolException
{
    /**
     * InvalidSignatureException constructor.
     * @param $message
     */
    public function __construct($message)
    {
        parent::__construct($message, ResponseCode::INVALID_SIGNATURE);
    }
}
