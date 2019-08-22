<?php

declare(strict_types=1);

namespace System\Repository\ItemTypes;
use System\Entity\Repository\ItemType;


/**
 * Interface ItemTypesRepositoryInterface
 * @package System\Repository\ItemTypes
 */
interface ItemTypesRepositoryInterface
{
    public function clearItemTypes(): void;

    /**
     * @param ItemType[] $itemTypes
     * @return int
     */
    public function saveItemTypes(array $itemTypes): int;

    /**
     * @param int $itemId
     * @return array
     */
    public function findTypesForItem(int $itemId): array;
}