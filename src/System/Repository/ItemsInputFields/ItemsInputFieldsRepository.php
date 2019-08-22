<?php

declare(strict_types=1);

namespace System\Repository\ItemsInputFields;

use System\Entity\Provider\InputField;
use System\Entity\Repository\ItemInputField;
use System\Repository\AbstractPdoRepository;

/**
 * Class ItemsInputFieldsRepository
 * @package System\Repository\ItemsInputFields
 */
class ItemsInputFieldsRepository extends AbstractPdoRepository implements ItemsInputFieldsRepositoryInterface
{
    /**
     * @param int $itemId
     *
     * @return ItemInputField[]
     */
    public function findAllByItemId(int $itemId): array
    {
        $sql = 'select iif.id, iif.item_id, iif.`order`, iif.min_length, iif.max_length,
                  iif.pattern, iif.is_mobile, iif.typing_style, iif.prefixes
                from items_input_fields as iif
                  join items_input_fields_localization as iifl on iif.id = iifl.items_input_id
                where iif.item_id = :itemId';

        $rows = $this->execAssoc($sql, [
            'itemId'=>$itemId
        ]);

        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->inflate($row);
        }
        return $result;
    }

    /**
     * @param int $itemId
     * @param int $order
     *
     * @return ItemInputField
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findByItemIdAndOrder(int $itemId, int $order): ItemInputField
    {
        $sql = 'select distinct iif.id, iif.item_id, iif.`order`, iif.min_length, iif.max_length,
                  iif.pattern, iif.is_mobile, iif.typing_style, iif.prefixes
                from items_input_fields as iif
                  join items_input_fields_localization as iifl on iif.id = iifl.items_input_id
                where iif.item_id = :itemId and iif.`order` = :orderId';

        $row = $this->execAssocOne($sql, [
            'itemId' => $itemId,
            'orderId' => $order
        ]);

        return $this->inflate($row);
    }

    /**
     * @param array $row
     * @return ItemInputField
     */
    private function inflate(array $row): ItemInputField
    {
        return new ItemInputField(
            (int) $row['item_id'],
            (int) $row['order'],
            (int) $row['min_length'],
            (int) $row['max_length'],
            $row['pattern'],
            (int) $row['is_mobile'],
            (int) $row['typing_style'],
            $row['prefixes'],
            (int)$row['id']
        );
    }

    /**
     * @return void
     */
    public function clearItemsInputFields(): void
    {
        $sql = 'truncate table items_input_fields';
        $this->update($sql, []);
    }

    /**
     * @param InputField $inputField
     * @return int
     * @throws \System\Exception\DiException
     */
    public function saveItemsInputFields(InputField $inputField): int
    {
        $sql = 'insert into items_input_fields 
                  (item_id, `order`, min_length, max_length, pattern, is_mobile, typing_style, prefixes) 
                value (:itemId, :order, :minLength, :maxLength, :pattern, :isMobile, :typingStyle, :prefixes)';

        $placeholders = [
            "itemId"=>$inputField->getItemId(),
            "order"=>$inputField->getOrder(),
            "minLength"=>$inputField->getMinLength(),
            "maxLength"=>$inputField->getMaxLength(),
            "pattern"=>$inputField->getPattern(),
            "isMobile"=>$inputField->getisMobile(),
            "typingStyle"=>$inputField->getTypingStyle(),
            "prefixes"=>$inputField->getPrefixes()
        ];

        return $this->insert($sql, $placeholders);
    }
}