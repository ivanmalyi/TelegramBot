<?php

declare(strict_types=1);

namespace System\Exception\Protocol;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class MccCodeNotSupportedException
 * @package System\Exception\Protocol
 */
class MccCodeNotSupportedException extends ProtocolException
{
    /**
     * MccCodeNotSupportedException constructor.
     * @param int $code
     */
    public function __construct(int $code)
    {
        parent::__construct(
            'Service code '.$code.' not supported',
            ResponseCode::MCC_NOT_SUPPORTED
        );
    }
}
