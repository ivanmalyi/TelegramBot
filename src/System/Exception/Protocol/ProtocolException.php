<?php

declare(strict_types=1);

namespace System\Exception\Protocol;

class ProtocolException extends \Exception
{
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}
