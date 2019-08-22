<?php

declare(strict_types=1);

namespace System\Repository\ItemsInputFields;

use System\Entity\Provider\InputField;
use System\Entity\Repository\ItemInputField;

/**
 * Interface ItemsInputFieldsRepositoryInterface
 * @package System\Repository\ItemsInputFields
 */
interface ItemsInputFieldsRepositoryInterface
{
    /**
     * @param int $itemId
     *
     * @return ItemInputField[]
     */
    public function findAllByItemId(int $itemId): array;

    /**
     * @param int $itemId
     * @param int $order
     *
     * @return ItemInputField
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findByItemIdAndOrder(int $itemId, int $order): ItemInputField;

    /**
     * @return void
     */
    public function clearItemsInputFields(): void;

    /**
     * @param InputField $inputField
     * @return int
     */
    public function saveItemsInputFields(InputField $inputField): int;
}