<?php

declare(strict_types=1);

namespace System\Repository\ItemsTags;


use System\Entity\Repository\ItemTag;
use System\Repository\AbstractPdoRepository;

/**
 * Class ItemsTagsRepository
 * @package System\Repository\ItemsTags
 */
class ItemsTagsRepository extends AbstractPdoRepository implements ItemsTagsRepositoryInterface
{
    public function clearItemsTags(): void
    {
        $sql = 'truncate table items_tags';
        $this->update($sql, []);
    }

    /**
     * @param ItemTag[] $itemsTags
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function saveItemsTags(array $itemsTags): int
    {
        $sql =/**@lang text*/
            'insert into items_tags (item_id, tags) values ';
        $placeholders = [];
        foreach ($itemsTags as $key=>$itemTag) {
            $sql .="(:itemId{$key}, :tags{$key}),";
            $placeholders += [
                "itemId{$key}"=>$itemTag->getItemId(),
                "tags{$key}"=>$itemTag->getTags()
            ];
        }

        return $this->insert(rtrim($sql, ','), $placeholders);
    }

    /**
     * @param string $tags
     *
     * @return ItemTag[]
     */
    public function findItemIdByTag(string $tags): array
    {
        $sql = 'select item_id, tags 
                from items_tags
                where tags like :tags0 or tags like :tags1 or tags like :tags2 or tags like :tags3';

        $rows = $this->execAssoc($sql, [
            'tags0'=>"%{$tags};%",
            'tags1'=>"%;{$tags};%",
            'tags2'=>"%;{$tags}%",
            'tags3'=>"{$tags}"
        ]);

        $itemsTags = [];
        foreach ($rows as $row) {
            $itemsTags[] = $this->inflate($row);
        }

        return $itemsTags;
    }

    /**
     * @param array $row
     *
     * @return ItemTag
     */
    private function inflate(array $row): ItemTag
    {
        return new ItemTag(
            (int)$row['item_id'],
            $row['tags']
        );
    }

    /**
     * @param string $tags
     *
     * @return ItemTag[]
     */
    public function findItemIdByTagWithoutRule(string $tags): array
    {
        $sql = 'select item_id, tags 
                from items_tags
                where tags like :tags';

        $rows = $this->execAssoc($sql, [
            'tags'=>"%{$tags}%"
        ]);

        $itemsTags = [];
        foreach ($rows as $row) {
            $itemsTags[] = $this->inflate($row);
        }

        return $itemsTags;
    }
}