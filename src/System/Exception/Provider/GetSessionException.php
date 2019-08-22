<?php

declare(strict_types=1);

namespace System\Exception\Provider;

use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class GetSessionException
 * @package System\Exception\Provider
 */
class GetSessionException extends ProviderException
{
    /**
     * GetSessionException constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message, int $code = ResponseCode::PROVIDER_ERROR)
    {
        parent::__construct($message, $code);
    }
}
