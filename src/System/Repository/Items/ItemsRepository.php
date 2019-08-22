<?php

declare(strict_types=1);

namespace System\Repository\Items;


use System\Entity\Repository\Item;
use System\Entity\Repository\ItemWithLocalization;
use System\Repository\AbstractPdoRepository;

/**
 * Class ItemsRepository
 * @package System\Repository\Items
 */
class ItemsRepository extends AbstractPdoRepository implements ItemsRepositoryInterface
{
    /**
     * @param string $itemTitle
     *
     * @return Item
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findItemByTitle(string $itemTitle): Item
    {
        $sql = "select id, service_id, image, min_amount, max_amount, status, title, mcc
                from items
                where title = :itemTitle";

        $row = $this->execAssocOne($sql, ['itemTitle'=>$itemTitle]);

        return $this->inflate($row);
    }

    /**
     * @param array $row
     * @return Item
     */
    private function inflate(array $row): Item
    {
        return new Item(
            (int)$row['service_id'],
            $row['image'],
            (int)$row['min_amount'],
            (int)$row['max_amount'],
            (int)$row['status'],
            (int)$row['mcc'],
            (int)$row['id']
        );
    }

    /**
     * @param int $serviceId
     * @param string $localization
     *
     * @return ItemWithLocalization[]
     */
    public function findItemsByServiceId(int $serviceId, string $localization): array
    {
        $sql = "select i.id, i.service_id, i.image, i.min_amount, i.max_amount, i.status, il.name
                from items as i
                left join items_localization as il on il.item_id = i.id
                where i.service_id = :serviceId and il.localization = :localization and i.status = 1";

        $rows = $this->execAssoc($sql, [
            'serviceId'=>$serviceId,
            'localization'=>$localization
        ]);

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->inflateItemsWithLocalization($row);
        }

        return $items;
    }

    /**
     * @param $row
     * @return ItemWithLocalization
     */
    private function inflateItemsWithLocalization($row)
    {
        return new ItemWithLocalization(
            (int)$row['service_id'],
            $row['image'],
            (int)$row['min_amount'],
            (int)$row['max_amount'],
            (int)$row['status'],
            $row['name'],
            (int)$row['id']
        );
    }

    /**
     *
     */
    public function clearItems(): void
    {
        $sql = 'truncate table items';
        $this->update($sql, []);
    }

    /**
     * @param Item[] $items
     * @return int
     * @throws \System\Exception\DiException
     */
    public function saveItems(array $items): int
    {
        $sql =/**@lang text*/
            'insert into items (id, service_id, image, min_amount, max_amount, status, mcc) values ';
        $placeholders = [];
        foreach ($items as $key=>$item) {
            $sql .="(:id{$key}, :serviceId{$key}, :image{$key}, :minAmount{$key}, :maxAmount{$key}, :status{$key}, :mcc{$key}),";
            $placeholders += [
                "id{$key}" => $item->getId(),
                "serviceId{$key}" => $item->getServiceId(),
                "image{$key}" => $item->getImage(),
                "minAmount{$key}" => $item->getMinAmount(),
                "maxAmount{$key}" => $item->getMaxAmount(),
                "status{$key}" => $item->getStatus(),
                "mcc{$key}" => $item->getMcc()
            ];
        }

        return $this->insert(rtrim($sql, ','), $placeholders);
    }

    /**
     * @param int $id
     *
     * @return Item
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findById(int $id): Item
    {
        $sql = "select id, service_id, image, min_amount, max_amount, status, title, mcc
                from items
                where id = :itemId";

        $row = $this->execAssocOne($sql, ['itemId' => $id]);

        return $this->inflate($row);
    }

    /**
     * @return Item[]
     */
    public function findAllItems(): array
    {
        $sql = "select id, service_id, image, min_amount, max_amount, status, title, mcc
                from items
                where status = 1";

        $rows = $this->execAssoc($sql, []);

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->inflate($row);
        }

        return $items;
    }

    /**
     * @param int $itemId
     * @param int $status
     *
     * @return int
     */
    public function updateStatus(int $itemId, int $status): int
    {
        $sql = 'update items
                set status = :status
                where id = :itemId';

        return $this->update($sql, ['status'=>$status, 'itemId'=>$itemId]);
    }
}