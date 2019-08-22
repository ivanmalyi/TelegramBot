<?php

declare(strict_types=1);

namespace System\Exception\Provider;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class OperationNotFound
 * @package System\Exception\Provider
 */
class OperationNotFound extends ProviderException
{
    /**
     * OperationNotFound constructor.
     */
    public function __construct()
    {
        parent::__construct('Operation not found', ResponseCode::UNKNOWN_ERROR);
    }
}
