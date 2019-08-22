<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class Emoji
 * @package System\Entity\Repository
 */
class Emoji
{
    /**
     * @var string
     */
    private $unicode;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $id;

    /**
     * Emoji constructor.
     * @param string $unicode
     * @param string $description
     * @param int $id
     */
    public function __construct(string $unicode, string $description, int $id = 0)
    {
        $this->unicode = $unicode;
        $this->description = $description;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUnicode(): string
    {
        return $this->unicode;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}