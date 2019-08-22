<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class ChequeCallbackUrl
 * @package System\Entity\Repository
 */
class ChequeCallbackUrl
{
    const NEW = 0;
    const ERROR = -10;
    const OK_CARD_DATA_INPUT = 2;
    const SECURE_3D = 10;

    /**
     * @var string
     */
    private $guid;

    /**
     * @var int
     */
    private $status;

    /**
     * @var int
     */
    private $chequeId;

    /**
     * @var int
     */
    private $callbackUrlId;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $updatedAt;

    /**
     * @var int
     */
    private $id;

    /**
     * ChequeCallbackUrl constructor.
     * @param string $guid
     * @param int $status
     * @param int $chequeId
     * @param int $callbackUrlId
     * @param string $createdAt
     * @param string $updatedAt
     * @param int $id
     */
    public function __construct(
        string $guid,
        int $status,
        int $chequeId,
        int $callbackUrlId,
        string $createdAt,
        string $updatedAt,
        int $id = 0
    )
    {
        $this->guid = $guid;
        $this->status = $status;
        $this->chequeId = $chequeId;
        $this->callbackUrlId = $callbackUrlId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getChequeId(): int
    {
        return $this->chequeId;
    }

    /**
     * @return int
     */
    public function getCallbackUrlId(): int
    {
        return $this->callbackUrlId;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public static function generatePageGuid(): string
    {
        return sprintf(
            '%04X_%04X%04X%04X',
            mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535)
        );
    }
}
