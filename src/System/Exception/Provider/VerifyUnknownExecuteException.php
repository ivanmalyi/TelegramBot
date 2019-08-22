<?php

declare(strict_types=1);

namespace System\Exception\Provider;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class VerifyUnknownExecuteException
 * @package System\Exception\Provider
 */
class VerifyUnknownExecuteException extends ProviderException
{
    /**
     * VerifyUnknownExecuteException constructor.
     */
    public function __construct()
    {
        parent::__construct("Unknown verify execute exception", ResponseCode::UNKNOWN_ERROR);
    }
}
