<?php

declare(strict_types=1);

namespace System\Exception\Command;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class LinkWalletGenerateSessionException
 * @package System\Exception\Command
 */
class LinkWalletGenerateSessionException extends CommandException
{
    public function __construct($message)
    {
        parent::__construct($message, ResponseCode::UNKNOWN_ERROR);
    }
}
