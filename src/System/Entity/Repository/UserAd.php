<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class UserAd
 * @package System\Entity\Repository
 */
class UserAd
{
    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $guid;

    /**
     * @var string
     */
    private $utmSource;

    /**
     * @var string
     */
    private $utmMedium;

    /**
     * @var string
     */
    private $utmTerm;

    /**
     * @var string
     */
    private $utmContent;

    /**
     * @var string
     */
    private $utmCampaign;

    /**
     * @var string
     */
    private $refOriginal;

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
     * UserAd constructor.
     * @param int $userId
     * @param string $guid
     * @param string $utmSource
     * @param string $utmMedium
     * @param string $utmTerm
     * @param string $utmContent
     * @param string $utmCampaign
     * @param string $refOriginal
     * @param string $createdAt
     * @param string $updatedAt
     * @param int $id
     */
    public function __construct(
        int $userId,
        string $guid,
        string $utmSource,
        string $utmMedium,
        string $utmTerm,
        string $utmContent,
        string $utmCampaign,
        string $refOriginal,
        string $createdAt,
        string $updatedAt,
        int $id = 0
    )
    {
        $this->userId = $userId;
        $this->guid = $guid;
        $this->utmSource = $utmSource;
        $this->utmMedium = $utmMedium;
        $this->utmTerm = $utmTerm;
        $this->utmContent = $utmContent;
        $this->utmCampaign = $utmCampaign;
        $this->refOriginal = $refOriginal;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }

    /**
     * @return string
     */
    public function getUtmSource(): string
    {
        return $this->utmSource;
    }

    /**
     * @return string
     */
    public function getUtmMedium(): string
    {
        return $this->utmMedium;
    }

    /**
     * @return string
     */
    public function getUtmTerm(): string
    {
        return $this->utmTerm;
    }

    /**
     * @return string
     */
    public function getUtmContent(): string
    {
        return $this->utmContent;
    }

    /**
     * @return string
     */
    public function getUtmCampaign(): string
    {
        return $this->utmCampaign;
    }

    /**
     * @return string
     */
    public function getRefOriginal(): string
    {
        return $this->refOriginal;
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
}
