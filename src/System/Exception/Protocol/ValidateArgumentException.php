<?php

namespace System\Exception\Protocol;

use System\Entity\InternalProtocol\ResponseCode;

class ValidateArgumentException extends ProtocolException
{
    /**
     * InvalidArgumentException constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        parent::__construct(
            sprintf('Validate argument {%s} error', $key),
            ResponseCode::INVALID_ARGUMENT
        );
    }
}
