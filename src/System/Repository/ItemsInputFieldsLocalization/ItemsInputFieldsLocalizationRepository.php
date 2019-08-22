<?php

declare(strict_types=1);

namespace System\Repository\ItemsInputFieldsLocalization;

use System\Entity\Provider\FieldName;
use System\Entity\Repository\ItemInputFieldLocalization;
use System\Repository\AbstractPdoRepository;

/**
 * Class ItemsInputFieldsLocalizationRepository
 * @package System\Repository\ItemsInputFieldsLocalization
 */
class ItemsInputFieldsLocalizationRepository extends AbstractPdoRepository implements ItemsInputFieldsLocalizationRepositoryInterface
{
    public function clearItemsInputFieldsLocalization(): void
    {
        $sql = 'truncate table items_input_fields_localization';
        $this->update($sql, []);
    }

    /**
     * @param FieldName[] $fieldNames
     * @param int $itemInputId
     * @return int
     * @throws \System\Exception\DiException
     */
    public function saveItemsInputFieldsLocalization(array $fieldNames, int $itemInputId): int
    {
        $sql = /**@lang text*/
            'insert into items_input_fields_localization (items_input_id, localization, field_name, instruction) values';

        $placeholders = [];
            foreach ($fieldNames as $key=>$fieldName) {
                $sql .= "(:itemInputId{$key}, :localization{$key}, :fieldName{$key}, :instruction{$key}),";
                $placeholders += [
                    "itemInputId{$key}"=>$itemInputId,
                    "localization{$key}"=>$fieldName->getLanguage(),
                    "fieldName{$key}"=>$fieldName->getFieldName(),
                    "instruction{$key}"=>$fieldName->getInstruction(),
                ];
            }

        return $this->insert(rtrim($sql, ','), $placeholders);
    }

    /**
     * @param int $itemInputId
     * @param string $localization
     *
     * @return ItemInputFieldLocalization
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findByItemInputId(int $itemInputId, string $localization): ItemInputFieldLocalization
    {
        $sql = 'select id, items_input_id, localization, field_name, instruction
          from items_input_fields_localization
          where items_input_id = :itemInputId and localization=:localization';

        $row = $this->execAssocOne($sql, [
            'itemInputId' => $itemInputId,
            'localization' => $localization
        ]);

        return $this->inflate($row);
    }

    /**
     * @param array $row
     * @return ItemInputFieldLocalization
     */
    private function inflate(array $row): ItemInputFieldLocalization
    {
        return new ItemInputFieldLocalization(
            (int) $row['items_input_id'],
            $row['localization'],
            $row['field_name'],
            $row['instruction'],
            (int) $row['id']
        );
    }
}