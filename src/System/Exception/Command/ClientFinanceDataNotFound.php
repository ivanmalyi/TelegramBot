<?php

declare(strict_types=1);

namespace System\Exception\Command;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class ClientFinanceDataNotFound
 * @package System\Exception\Command
 */
class ClientFinanceDataNotFound extends CommandException
{
    /**
     * CardNotValid constructor.
     * @param string $cardNumber
     */
    public function __construct()
    {
        parent::__construct("Client's finance data not found", ResponseCode::MISSING_ARGUMENT);
    }
}
