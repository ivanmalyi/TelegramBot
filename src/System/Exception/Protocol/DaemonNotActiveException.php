<?php

declare(strict_types=1);

namespace System\Exception\Protocol;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class DaemonNotActiveException
 * @package System\Exception\Protocol
 */
class DaemonNotActiveException extends ProtocolException
{
    /**
     * DaemonNotActiveException constructor.
     * @param $daemonName
     */
    public function __construct($daemonName)
    {
        parent::__construct($daemonName, ResponseCode::UNKNOWN_ERROR);
    }
}
