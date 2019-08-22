<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class Message
 * @package System\Entity\Repository
 */
class Message
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var int
     */
    private $stage;

    /**
     * @var int
     */
    private $status;

    /**
     * @var int
     */
    private $id;

    /**
     * Message constructor.
     * @param string $message
     * @param int $stage
     * @param int $status
     * @param int $id
     */
    public function __construct(string $message, int $stage, int $status, int $id = 0)
    {
        $this->message = $message;
        $this->stage = $stage;
        $this->status = $status;
        $this->id = $id;
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
    public function getStage(): int
    {
        return $this->stage;
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
    public function getId(): int
    {
        return $this->id;
    }
}