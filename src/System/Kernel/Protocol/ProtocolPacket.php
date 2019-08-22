<?php

declare(strict_types=1);

namespace System\Kernel\Protocol;

use System\Util\ConverterClass\ToStringTrait;

/**
 * Class ProtocolPacket
 * @package System\Kernel\Protocol
 */
class ProtocolPacket
{
    use ToStringTrait;
    
    /**
     * @var string
     */
    private $data;

    /**
     * @var string
     */
    private $signature;

    /**
     * @var array
     */
    private $headers;

    /**
     * ProtocolPacket constructor.
     * @param string $data
     * @param string $signature
     * @param array $headers
     */
    public function __construct(string $data, string $signature, array $headers = [])
    {
        $this->data = $data;
        $this->signature = $signature;
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getData() : string
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData(string $data): void
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getSignature() : string
    {
        return $this->signature;
    }

    /**
     * @return array
     */
    public function getHeaders() : array
    {
        return $this->headers;
    }
}
