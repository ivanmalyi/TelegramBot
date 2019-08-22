<?php

declare(strict_types=1);

namespace System\Repository\Items;

use System\Entity\Repository\Item;
use System\Entity\Repository\ItemWithLocalization;
use System\Exception\EmptyFetchResultException;


/**
 * Class ItemsRepositoryInterface
 * @package System\Repository
 */
interface ItemsRepositoryInterface
{
    /**
     * @param string $itemTitle
     * @return Item
     * @throws EmptyFetchResultException
     */
    public function findItemByTitle(string $itemTitle): Item;

    /**
     * @param int $serviceId
     * @param string $localization
     *
     * @return ItemWithLocalization[]
     */
    public function findItemsByServiceId(int $serviceId, string $localization): array;

    /**
     *
     */
    public function clearItems(): void;

    /**
     * @param array $items
     * @return int
     */
    public function saveItems(array $items): int;

    /**
     * @param int $id
     *
     * @return Item
     *
     * @throws EmptyFetchResultException
     */
    public function findById(int $id): Item;

    /**
     * @return Item[]
     */
    public function findAllItems(): array;

    /**
     * @param int $itemId
     * @param int $status
     *
     * @return int
     */
    public function updateStatus(int $itemId, int $status): int;
}