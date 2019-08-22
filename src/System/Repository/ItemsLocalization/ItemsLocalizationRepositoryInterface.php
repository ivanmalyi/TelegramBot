<?php

declare(strict_types=1);

namespace System\Repository\ItemsLocalization;


use System\Entity\Repository\ItemLocalization;


/**
 * Interface ItemsLocalizationRepositoryInterface
 * @package System\Repository\ItemsLocalization
 */
interface ItemsLocalizationRepositoryInterface
{
    /**
     *
     */
    public function clearItemsLocalization(): void;

    /**
     * @param ItemLocalization[] $itemsLocalization
     * @return int
     */
    public function saveItemsLocalization(array $itemsLocalization): int;

    /**
     * @param array $itemsId
     * @param string $localization
     *
     * @return ItemLocalization[]
     */
    public function findItemsByIdAndLocale(array $itemsId, string $localization): array;

    /**
     * @param int $itemId
     * @param string $localization
     *
     * @return ItemLocalization
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findItemByIdAndLocale(int $itemId, string $localization): ItemLocalization;
}