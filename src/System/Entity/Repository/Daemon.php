<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class Daemon
 * @package System\Entity\Component
 */
class Daemon
{
    const ACTIVE_STATUS = 1;
    const DISABLE_STATUS = 0;

    const CHECK = 'check';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $status;

    /**
     * Daemon constructor.
     * @param int $id
     * @param string $name
     * @param int $status
     */
    public function __construct(string $name, int $status, int $id = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}
