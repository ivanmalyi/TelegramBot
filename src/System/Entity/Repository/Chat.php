<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class Chat
 * @package System\Entity\Repository
 */
class Chat
{
    /**
     * @var int
     */
    private $userId;

    /**
     * @var int
     */
    private $currentStage;

    /**
     * @var int
     */
    private $currentSubStage;

    /**
     * @var int
     */
    private $currentChequeId;

    /**
     * @var string
     */
    private $currentLocalization;

    /**
     * @var int
     */
    private $providerChatId;

    /**
     * @var int
     */
    private $chatBotId;

    /**
     * @var string
     */
    private $currentSessionGuid;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var int
     */
    private $attempts;

    /**
     * @var int
     */
    private $id;

    /**
     * Chat constructor.
     * @param int $userId
     * @param int $currentStage
     * @param int $currentSubStage
     * @param int $currentChequeId
     * @param string $currentLocalization
     * @param int $providerChatId
     * @param int $chatBotId
     * @param string $currentSessionGuid
     * @param string $phone
     * @param int $attempts
     * @param int $id
     */
    public function __construct(
        int $userId,
        int $currentStage,
        int $currentSubStage,
        int $currentChequeId,
        string $currentLocalization,
        int $providerChatId,
        int $chatBotId,
        string $currentSessionGuid,
        string $phone = '',
        int $attempts = 0,
        int $id = 0
    )
    {
        $this->userId = $userId;
        $this->currentStage = $currentStage;
        $this->currentSubStage = $currentSubStage;
        $this->currentChequeId = $currentChequeId;
        $this->currentLocalization = $currentLocalization;
        $this->providerChatId = $providerChatId;
        $this->chatBotId = $chatBotId;
        $this->currentSessionGuid = $currentSessionGuid;
        $this->phone = $phone;
        $this->attempts = $attempts;
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
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getCurrentStage(): int
    {
        return $this->currentStage;
    }

    /**
     * @param int $currentStage
     */
    public function setCurrentStage(int $currentStage): void
    {
        $this->currentStage = $currentStage;
    }

    /**
     * @return int
     */
    public function getProviderChatId(): int
    {
        return $this->providerChatId;
    }

    /**
     * @return int
     */
    public function getChatBotId(): int
    {
        return $this->chatBotId;
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
     * @return int
     */
    public function getCurrentSubStage(): int
    {
        return $this->currentSubStage;
    }

    /**
     * @param int $currentSubStage
     */
    public function setCurrentSubStage(int $currentSubStage): void
    {
        $this->currentSubStage = $currentSubStage;
    }

    /**
     * @return int
     */
    public function getCurrentChequeId(): int
    {
        return $this->currentChequeId;
    }

    /**
     * @param int $currentChequeId
     */
    public function setCurrentChequeId(int $currentChequeId): void
    {
        $this->currentChequeId = $currentChequeId;
    }

    /**
     * @return string
     */
    public function getCurrentLocalization(): string
    {
        return $this->currentLocalization;
    }

    /**
     * @param string $currentLocalization
     */
    public function setCurrentLocalization(string $currentLocalization): void
    {
        $this->currentLocalization = $currentLocalization;
    }

    /**
     * @return string
     */
    public function getCurrentSessionGuid(): string
    {
        return $this->currentSessionGuid;
    }

    /**
     * @param string $currentSessionGuid
     */
    public function setCurrentSessionGuid(string $currentSessionGuid): void
    {
        $this->currentSessionGuid = $currentSessionGuid;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return int
     */
    public function getAttempts(): int
    {
        return $this->attempts;
    }

    /**
     * @param int $attempts
     */
    public function setAttempts(int $attempts): void
    {
        $this->attempts = $attempts;
    }

    /**
     * @return string
     */
    public static function generateSessionGuid(): string
    {
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535),
            mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
}
