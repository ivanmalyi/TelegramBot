<?php

declare(strict_types=1);

namespace System\Exception\Provider;

/**
 * Class CurlException
 * @package System\Exception
 */
class CurlException extends ProviderException
{
    /**
     * CurlException constructor.
     * @param int $code
     * @param string $message
     */
    public function __construct(int $code, string $message = 'Curl error')
    {
        parent::__construct($message, $code);
    }
}
