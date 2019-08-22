<?php

declare(strict_types=1);

namespace System\Entity\Provider;

use System\Util\ConverterClass\ToStringTrait;

/**
 * Class HttpsResponse
 * @package System\Entity\Provider
 */
class HttpsResponse
{
    use ToStringTrait;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var string
     */
    private $body;

    /**
     * @var int
     */
    private $httpCode;

    /**
     * HttpsResponse constructor.
     * @param array $headers
     * @param string $body
     * @param int $httpCode
     */
    public function __construct(array $headers, string $body, int $httpCode = 0)
    {
        $this->headers = $headers;
        $this->body = $body;
        $this->httpCode = $httpCode;
    }

    /**
     * @return array
     */
    public function getHeaders() : array
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getBody() : string
    {
        return $this->body;
    }

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }
}
