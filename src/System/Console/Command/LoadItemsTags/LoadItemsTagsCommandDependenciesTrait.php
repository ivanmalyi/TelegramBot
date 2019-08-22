<?php

declare(strict_types=1);

namespace System\Console\Command\LoadItemsTags;
use System\Exception\DiException;
use System\Repository\ItemsTags\ItemsTagsRepositoryInterface;


/**
 * Class LoadItemsTagsCommandDependenciesTrait
 * @package System\Console\Command\LoadItemsTags
 */
trait LoadItemsTagsCommandDependenciesTrait
{
    /**
     * @var ItemsTagsRepositoryInterface
     */
    private $itemsTagsRepository;

    /**
     * @return ItemsTagsRepositoryInterface
     * @throws DiException
     */
    public function getItemsTagsRepository(): ItemsTagsRepositoryInterface
    {
        if (null === $this->itemsTagsRepository) {
            throw new DiException('ItemsTagsRepository');
        }

        return $this->itemsTagsRepository;
    }

    /**
     * @param ItemsTagsRepositoryInterface $itemsTagsRepository
     */
    public function setItemsTagsRepository(ItemsTagsRepositoryInterface $itemsTagsRepository): void
    {
        $this->itemsTagsRepository = $itemsTagsRepository;
    }
}