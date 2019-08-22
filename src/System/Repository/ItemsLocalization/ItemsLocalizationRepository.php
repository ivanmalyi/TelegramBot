<?php

declare(strict_types=1);

namespace System\Repository\ItemsLocalization;


use System\Entity\Repository\ItemLocalization;
use System\Repository\AbstractPdoRepository;

/**
 * Class ItemsLocalizationRepository
 * @package System\Repository\ItemsLocalization
 */
class ItemsLocalizationRepository extends AbstractPdoRepository implements ItemsLocalizationRepositoryInterface
{
    public function clearItemsLocalization(): void
    {
        $sql = 'truncate table items_localization';
        $this->update($sql, []);
    }

    /**
     * @param ItemLocalization[] $itemsLocalization
     * @return int
     * @throws \System\Exception\DiException
     */
    public function saveItemsLocalization(array $itemsLocalization): int
    {
        $sql = /**@lang text*/
            'insert into items_localization (item_id, localization, name, description) values ';

        $placeholders = [];
        foreach ($itemsLocalization as $key=>$itemLocalization) {
            $sql .= "(:itemId{$key}, :localization{$key}, :name{$key}, :description{$key}),";
            $placeholders += [
                "itemId{$key}"=>$itemLocalization->getItemId(),
                "localization{$key}"=>$itemLocalization->getLocalization(),
                "name{$key}"=>$itemLocalization->getName(),
                "description{$key}"=>$itemLocalization->getDescription(),
            ];
        }

        return $this->insert(rtrim($sql, ','), $placeholders);
    }

    /**
     * @param array $itemsId
     * @param string $localization
     *
     * @return ItemLocalization[]
     */
    public function findItemsByIdAndLocale(array $itemsId, string $localization): array
    {
        $itemsId = implode(',', $itemsId);
        $sql = "select il.id, il.item_id, il.localization, il.name, il.description 
                from items_localization as il
                left join items as i on i.id = il.item_id
                where il.item_id in ({$itemsId}) and il.localization = :localization and i.status = 1";


        $rows = $this->execAssoc($sql, ['localization'=>$localization]);

        $itemsLocalization = [];
        foreach ($rows as $row) {
            $itemsLocalization[] = $this->inflate($row);
        }

        return $itemsLocalization;
    }

    /**
     * @param array $row
     *
     * @return ItemLocalization
     */
    private function inflate(array $row): ItemLocalization
    {
        return new ItemLocalization(
            (int)$row['item_id'],
            $row['localization'],
            $row['name'],
            $row['description'],
            (int)$row['id']
        );
    }

    /**
     * @param int $itemId
     * @param string $localization
     *
     * @return ItemLocalization
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findItemByIdAndLocale(int $itemId, string $localization): ItemLocalization
    {
        $sql = "select il.id, il.item_id, il.localization, il.name, il.description 
                from items_localization as il
                  join items as i on il.item_id=i.id
                where il.item_id = :itemId and il.localization = :localization and i.status = 1";


        $row = $this->execAssocOne($sql, ['localization'=>$localization, 'itemId'=>$itemId]);

        return $this->inflate($row);
    }
}