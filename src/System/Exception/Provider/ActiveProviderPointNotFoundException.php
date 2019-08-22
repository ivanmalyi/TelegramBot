<?php

declare(strict_types=1);

namespace System\Exception\Provider;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class ActiveProviderNotFoundException
 * @package System\Exception\Provider
 */
class ActiveProviderPointNotFoundException extends ProviderException
{
    /**
     * ActiveProviderNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Active provider point not found', ResponseCode::DATA_NOT_FOUND);
    }
}
