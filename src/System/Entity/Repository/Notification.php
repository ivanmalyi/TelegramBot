<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class Notification
 * @package System\Entity\Repository
 */
class Notification
{
    const EMAIL_TYPE = 'email';
    const TELEGRAM_TYPE = 'telegram';

    const PRE_AUTH_SOURCE = 'PreAuth';

    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $message;

    /**
     * @var int
     */
    private $id;

    /**
     * Date from which to look for old notifications
     *
     * @var string
     */
    private $fromSearch;

    /**
     * Notification constructor.
     * @param string $source
     * @param string $type
     * @param string $createdAt
     * @param string $message
     * @param int $id
     */
    public function __construct(string $source, string $type, string $createdAt, string $message, int $id = 0)
    {
        $this->source = $source;
        $this->type = $type;
        $this->createdAt = $createdAt;
        $this->message = $message;
        $this->id = $id;
        $this->fromSearch = '';
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
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
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFromSearch(): string
    {
        return $this->fromSearch;
    }

    /**
     * @param string $fromSearch
     */
    public function setFromSearch(string $fromSearch): void
    {
        $this->fromSearch = $fromSearch;
    }
}
