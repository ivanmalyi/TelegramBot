<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class MccCode
 * @package System\Entity\Repository
 */
class MccCode
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var int
     */
    private $id;

    /**
     * MccCode constructor.
     * @param string $name
     * @param string $createdAt
     * @param int $id
     */
    public function __construct(string $name, string $createdAt, int $id = 0)
    {
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
