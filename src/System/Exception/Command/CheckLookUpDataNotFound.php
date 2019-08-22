<?php

declare(strict_types=1);

namespace System\Exception\Command;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class CheckLookUpDataNotFound
 * @package System\Exception\Command
 */
class CheckLookUpDataNotFound extends CommandException
{
    /**
     * CheckLookUpDataNotFound constructor.
     * @param $message
     */
    public function __construct($message)
    {
        parent::__construct($message, ResponseCode::DATA_NOT_FOUND);
    }
}
