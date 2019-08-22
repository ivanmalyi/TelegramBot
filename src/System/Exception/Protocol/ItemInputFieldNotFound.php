<?php

declare(strict_types=1);

namespace System\Exception\Protocol;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class ItemInputFieldNotFound
 * @package System\Exception\Protocol
 */
class ItemInputFieldNotFound extends ProtocolException
{
    /**
     * ItemInputFieldNotFound constructor.
     */
    public function __construct()
    {
        parent::__construct("Item input field (localization) not found", ResponseCode::DATA_NOT_FOUND);
    }
}
