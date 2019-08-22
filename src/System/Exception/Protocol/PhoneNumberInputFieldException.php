<?php

declare(strict_types=1);

namespace System\Exception\Protocol;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class PhoneNumberInputFieldException
 * @package System\Exception\Protocol
 */
class PhoneNumberInputFieldException extends ProtocolException
{
    public function __construct()
    {
        parent::__construct('The item input field is a phone number', ResponseCode::UNKNOWN_ERROR);
    }
}
