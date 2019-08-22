<?php

declare(strict_types=1);

namespace System\Entity\Repository;

use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;

/**
 * Class User
 * @package System\Entity\Repository
 */
class User
{
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $phoneNumber;

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
     * User constructor.
     * @param string $firstName
     * @param string $lastName
     * @param string $phoneNumber
     * @param string $createdAt
     * @param string $updatedAt
     * @param int $id
     */
    public function __construct(
        string $firstName,
        string $lastName,
        string $phoneNumber,
        string $createdAt,
        string $updatedAt,
        int $id = 0
    )
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
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
     * @param TelegramRequest $telegramRequest
     * @return User
     */
    public static function buildFromTelegramRequest(TelegramRequest $telegramRequest): self
    {
        return new self(
            $telegramRequest->getMessage()->getChat()->getFirstName(),
            $telegramRequest->getMessage()->getChat()->getLastName(),
            '',
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        );
    }
}