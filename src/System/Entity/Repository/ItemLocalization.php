<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class ItemLocalization
 * @package System\Entity\Repository
 */
class ItemLocalization
{
    /**
     * @var int
     */
    private $itemId;

    /**
     * @var string
     */
    private $localization;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $id;

    /**
     * ItemLocalization constructor.
     * @param int $itemId
     * @param string $localization
     * @param string $name
     * @param string $description
     * @param int $id
     */
    public function __construct(int $itemId, string $localization, string $name, string $description, int $id = 0)
    {
        $this->itemId = $itemId;
        $this->localization = $localization;
        $this->name = $name;
        $this->description = $description;
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
     * @return string
     */
    public function getLocalization(): string
    {
        return $this->localization;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}