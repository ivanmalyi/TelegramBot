<?php

declare(strict_types=1);

namespace System\Repository\ItemsInputFieldsLocalization;

use System\Entity\Provider\FieldName;
use System\Entity\Repository\ItemInputFieldLocalization;

/**
 * Interface ItemsInputFieldsLocalizationRepositoryInterface
 * @package System\Repository\ItemsInputFieldsLocalization
 */
interface ItemsInputFieldsLocalizationRepositoryInterface
{
    /**
     * @return void
     */
    public function clearItemsInputFieldsLocalization(): void;

    /**
     * @param FieldName[] $fieldNames
     * @param int $itemInputId
     * @return int
     */
    public function saveItemsInputFieldsLocalization(array $fieldNames, int $itemInputId): int;

    /**
     * @param int $itemInputId
     * @param string $localization
     *
     * @return ItemInputFieldLocalization
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findByItemInputId(int $itemInputId, string $localization): ItemInputFieldLocalization;
}