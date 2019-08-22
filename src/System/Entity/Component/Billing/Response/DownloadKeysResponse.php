<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;

/**
 * Class DownloadKeysResponse
 * @package System\Entity\Component\Billing\Response
 */
class DownloadKeysResponse extends Response
{
    /**
     * @var string
     */
    private $privateKey;

    /**
     * @var string
     */
    private $publicKey;

    /**
     * DownloadKeysResponse constructor.
     * @param int $result
     * @param string $privateKey
     * @param string $publicKey
     * @param string $time
     */
    public function __construct(int $result, string $privateKey, string $publicKey, string $time)
    {
        parent::__construct($result, $time);
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
    }

    /**
     * @return string
     */
    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    /**
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * @param int $result
     * @return DownloadKeysResponse
     */
    public static function buildWhenError(int $result): self
    {
        return new self($result, '', '', date('Y-m-d H:i:s'));
    }
}
