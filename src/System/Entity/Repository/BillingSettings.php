<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class Key
 * @package System\Entity\Repository
 */
/**
 * Class BillingSettings
 * @package System\Entity\Repository
 */
class BillingSettings
{
    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $publicKey;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $privateKey;

    /**
     * @var string
     */
    private $clientKey;

    /**
     * @var int
     */
    private $id;

    /**
     * BillingSettings constructor.
     * @param string $login
     * @param string $password
     * @param string $publicKey
     * @param string $url
     * @param string $privateKey
     * @param string $clientKey
     * @param int $id
     */
    public function __construct(
        string $login,
        string $password,
        string $url,
        string $publicKey,
        string $privateKey,
        string $clientKey,
        int $id = 0
    )
    {
        $this->login = $login;
        $this->password = $password;
        $this->url = $url;
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->clientKey = $clientKey;
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
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
    public function getClientKey(): string
    {
        return $this->clientKey;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}