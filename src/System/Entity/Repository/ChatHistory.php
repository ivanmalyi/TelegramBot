<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class ChatHistory
 * @package System\Entity\Repository
 */
class ChatHistory
{
    /**
     * @var int
     */
    private $chatId;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var int
     */
    private $stage;

    /**
     * @var int
     */
    private $subStage;

    /**
     * @var string
     */
    private $localization;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $sessionGuid;

    /**
     * @var int
     */
    private $id;

    /**
     * ChatHistory constructor.
     * @param int $chatId
     * @param int $userId
     * @param int $stage
     * @param int $subStage
     * @param string $localization
     * @param string $createdAt
     * @param string $sessionGuid
     * @param int $id
     */
    public function __construct(
        int $chatId,
        int $userId,
        int $stage,
        int $subStage,
        string $localization,
        string $createdAt,
        string $sessionGuid,
        int $id = 0
    )
    {
        $this->chatId = $chatId;
        $this->userId = $userId;
        $this->stage = $stage;
        $this->subStage = $subStage;
        $this->localization = $localization;
        $this->createdAt = $createdAt;
        $this->sessionGuid = $sessionGuid;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chatId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getStage(): int
    {
        return $this->stage;
    }

    /**
     * @return int
     */
    public function getSubStage(): int
    {
        return $this->subStage;
    }

    /**
     * @return string
     */
    public function getLocalization(): string
    {
        return $this->localization;
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
    public function getSessionGuid(): string
    {
        return $this->sessionGuid;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
