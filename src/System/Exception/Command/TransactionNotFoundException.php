<?php

declare(strict_types=1);

namespace System\Exception\Command;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class TransactionNotFoundException
 * @package System\Exception\Command
 */
class TransactionNotFoundException extends CommandException
{
    /**
     * TransactionNotFoundException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message, ResponseCode::DATA_NOT_FOUND);
    }
}
