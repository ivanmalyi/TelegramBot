<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class ItemType
 * @package System\Entity\Repository
 */
class ItemType
{
    const GROUP_OF_PAYMENT = 6;

    /**
     * @var int
     */
    private $itemId;

    /**
     * @var int
     */
    private $type;

    /**
     * @var int
     */
    private $id;

    /**
     * ItemType constructor.
     * @param int $itemId
     * @param int $type
     * @param int $id
     */
    public function __construct(int $itemId, int $type, int $id = 0)
    {
        $this->itemId = $itemId;
        $this->type = $type;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getItemId(): int
    {
        return $this->itemId;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}