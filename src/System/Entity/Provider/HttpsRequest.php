<?php

declare(strict_types=1);

namespace System\Entity\Provider;

/**
 * Class HttpsRequest
 * @package System\Entity\Provider
 */
class HttpsRequest
{
    const DEFAULT_TIMEOUT = 15;

    const POST = 'POST';
    const PUT = 'PUT';
    const GET = 'GET';
    const DELETE = 'DELETE';
    
    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var string
     */
    private $body;

    /**
     * @var HttpAuth|null
     */
    private $httpAuth;

    /**
     * @var string
     */
    private $interface;

    /**
     * @var string
     */
    private $sslCertificate;

    /**
     * @var string
     */
    private $sslCertificatePassword;

    /**
     * @var string
     */
    private $sslKey;

    /**
     * @var string
     */
    private $sslKeyPassword;

    /**
     * @var int
     */
    private $timeout;

    /**
     * @var string
     */
    private $type;

    /**
     * HttpsRequest constructor.
     * @param string $url
     * @param array $headers
     * @param string $body
     * @param string $sslCertificate
     * @param string $sslCertificatePassword
     * @param HttpAuth|null $httpAuth
     * @param string $interface
     * @param string $sslKey
     * @param string $sslKeyPassword
     * @param int $timeout
     */
    public function __construct(
        string $url,
        array $headers = [],
        string $body = '',
        $httpAuth = null, 
        $sslCertificate = '',
        $sslCertificatePassword = '',
        string $interface = '',
        string $sslKey = '',
        string $sslKeyPassword = '',
        int $timeout = self::DEFAULT_TIMEOUT
    ) {
        $this->url = $url;
        $this->headers = $headers;
        $this->body = $body;
        $this->sslCertificate = $sslCertificate;
        $this->sslCertificatePassword = $sslCertificatePassword;
        $this->httpAuth = $httpAuth;
        $this->interface = $interface;
        $this->sslKey = $sslKey;
        $this->sslKeyPassword = $sslKeyPassword;
        $this->timeout = $timeout;
        $this->type = '';
    }

    /**
     * @return string
     */
    public function getUrl() : string
    {
        return $this->url;
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
     * @return HttpAuth|null
     */
    public function getHttpAuth()
    {
        return $this->httpAuth;
    }

    /**
     * @return string
     */
    public function getInterface() : string
    {
        return $this->interface;
    }

    /**
     * @return string
     */
    public function getSslCertificate() : string
    {
        return $this->sslCertificate;
    }

    /**
     * @return string
     */
    public function getSslCertificatePassword() : string
    {
        return $this->sslCertificatePassword;
    }

    /**
     * @return string
     */
    public function getSslKey() : string
    {
        return $this->sslKey;
    }

    /**
     * @return string
     */
    public function getSslKeyPassword() : string
    {
        return $this->sslKeyPassword;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout(int $timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }
}
