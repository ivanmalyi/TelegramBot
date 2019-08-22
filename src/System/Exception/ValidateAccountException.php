<?php

declare(strict_types=1);

namespace System\Exception;


class ValidateAccountException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Input account is invalid");
    }
}