<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class ItemTag
 * @package System\Entity\Repository
 */
class ItemTag
{
    /**
     * @var int
     */
    private $itemId;

    /**
     * @var string
     */
    private $tags;

    /**
     * ItemTag constructor.
     * @param int $itemId
     * @param string $tags
     */
    public function __construct(int $itemId, string $tags)
    {
        $this->itemId = $itemId;
        $this->tags = $tags;
    }

    /**
     * @return int
     */
    public function getItemId(): int
    {
        return $this->itemId;
    }

    /**
     * @return string
     */
    public function getTags(): string
    {
        return $this->tags;
    }
}