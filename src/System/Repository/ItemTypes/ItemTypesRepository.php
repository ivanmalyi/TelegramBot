<?php

declare(strict_types=1);

namespace System\Repository\ItemTypes;


use System\Entity\Repository\ItemType;
use System\Repository\AbstractPdoRepository;

class ItemTypesRepository extends AbstractPdoRepository implements ItemTypesRepositoryInterface
{
    public function clearItemTypes(): void
    {
        $sql = 'truncate table item_types';
        $this->update($sql, []);
    }

    /**
     * @param ItemType[] $itemTypes
     * @return int
     * @throws \System\Exception\DiException
     */
    public function saveItemTypes(array $itemTypes): int
    {
        $sql =/**@lang text*/
            'insert into item_types (item_id, type) values ';
        $placeholders = [];
        foreach ($itemTypes as $key=>$itemType) {
            $sql .="(:itemId{$key}, :type{$key}),";
            $placeholders += [
                "itemId{$key}"=>$itemType->getItemId(),
                "type{$key}"=>$itemType->getType()
            ];
        }

        return $this->insert(rtrim($sql, ','), $placeholders);
    }

    public function findTypesForItem(int $itemId): array
    {
        $sql = 'select type 
                from item_types
                where item_id = :itemId';

        $rows = $this->execAssoc($sql, ['itemId'=>$itemId]);

        $types = [];
        foreach ($rows as $row) {
            $types[] = (int)$row['type'];
        }

        return $types;
    }
}