<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;
use System\Entity\Repository\ItemTag;


/**
 * Class ItemsTagsResponse
 * @package System\Entity\Component\Billing\Response
 */
class LoadItemsTagsResponse extends Response
{
    /**
     * @var ItemTag[]
     */
    private $itemsTags;

    /**
     * ItemsTagsResponse constructor.
     * @param int $result
     * @param string $time
     * @param array $itemsTags
     */
    public function __construct(int $result, string $time, array $itemsTags)
    {
        parent::__construct($result, $time);
        $this->itemsTags = $itemsTags;
    }

    /**
     * @return ItemTag[]
     */
    public function getItemsTags(): array
    {
        return $this->itemsTags;
    }

    /**
     * @param int $result
     * @return LoadItemsTagsResponse
     */
    public static function buildWhenError(int $result): self
    {
        return new self(
            $result,
            date('Y-m-d H:i:s'),
            []
        );
    }
}