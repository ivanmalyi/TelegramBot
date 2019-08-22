<?php

declare(strict_types=1);

namespace System\Exception\Command;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class RefundException
 * @package System\Exception\Command
 */
class RefundException extends CommandException
{
    /**
     * RefundException constructor.
     * @param string $transactionStatus
     */
    public function __construct(string $transactionStatus)
    {
        parent::__construct(
            'Cannot refund transaction with status '.$transactionStatus,
            ResponseCode::TRANSACTION_CANNOT_BE_CANCELED
        );
    }
}
