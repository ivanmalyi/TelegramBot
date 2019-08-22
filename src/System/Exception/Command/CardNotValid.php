<?php

declare(strict_types=1);

namespace System\Exception\Command;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class CardNotValid
 * @package System\Exception\Command
 */
class CardNotValid extends CommandException
{
    /**
     * CardNotValid constructor.
     * @param string $cardNumber
     */
    public function __construct(string $cardNumber)
    {
        parent::__construct("Card ".$cardNumber." not valid", ResponseCode::INVALID_ARGUMENT);
    }
}
