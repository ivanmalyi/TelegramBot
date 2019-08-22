<?php

declare(strict_types=1);

namespace System\Exception\Command;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class OrderNotFoundException
 * @package System\Exception\Command
 */
class OrderNotFoundException extends CommandException
{
    /**
     * OrderNotFoundException constructor.
     * @param int $merchantOrderId
     */
    public function __construct(int $merchantOrderId)
    {
        parent::__construct('Order '.$merchantOrderId.' not found!', ResponseCode::DATA_NOT_FOUND);
    }
}
