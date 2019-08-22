<?php

declare(strict_types=1);

namespace System\Repository\ItemsTags;
use System\Entity\Repository\ItemTag;


/**
 * Interface ItemsTagsRepositoryInterface
 * @package System\Repository\ItemsTags
 */
interface ItemsTagsRepositoryInterface
{
    public function clearItemsTags(): void;

    /**
     * @param array $itemsTags
     *
     * @return int
     */
    public function saveItemsTags(array $itemsTags): int;

    /**
     * @param string $tags
     *
     * @return ItemTag[]
     */
    public function findItemIdByTag(string $tags): array;

    /**
     * @param string $tags
     *
     * @return ItemTag[]
     */
    public function findItemIdByTagWithoutRule(string $tags): array;
}