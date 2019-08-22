<?php

declare(strict_types=1);

namespace System\Exception\Protocol;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class DuplicateMerchantOrderException
 * @package System\Exception\Protocol
 */
class DuplicateMerchantOrderException extends ProtocolException
{
    /**
     * DuplicateMerchantOrderException constructor.
     * @param int $merchantOrderId
     */
    public function __construct(int $merchantOrderId)
    {
        parent::__construct(sprintf('Duplicate order '.$merchantOrderId), ResponseCode::DUPLICATE_COMMAND);
    }
}
