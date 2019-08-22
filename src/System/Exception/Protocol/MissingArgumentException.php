<?php

namespace System\Exception\Protocol;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class MissingArgumentException
 * @package Regulpay\Exception\Protocol
 */
class MissingArgumentException extends ProtocolException
{

    /**
     * MissingArgumentException constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        parent::__construct(
            sprintf('Missing argument {%s}', $key),
            ResponseCode::MISSING_ARGUMENT
        );
    }
}
