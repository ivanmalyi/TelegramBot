<?php

declare(strict_types=1);

namespace System\Exception\Command;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class TransactionAlreadyCompletedException
 * @package System\Exception\Command
 */
class TransactionAlreadyCompletedException extends CommandException
{
    /**
     * TransactionNotFoundException constructor.
     * @param string $message
     */
    public function __construct()
    {
        parent::__construct('Transaction already completed', ResponseCode::DUPLICATE_COMMAND);
    }
}
