<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class ItemInputFieldLocalization
 * @package System\Entity\Repository
 */
class ItemInputFieldLocalization
{
    /**
     * @var int
     */
    private $itemsInputId;

    /**
     * @var string
     */
    private $localization;

    /**
     * @var string
     */
    private $fieldName;

    /**
     * @var string
     */
    private $instruction;

    /**
     * @var int
     */
    private $id;

    /**
     * ItemInputFieldLocalization constructor.
     * @param int $itemsInputId
     * @param string $localization
     * @param string $fieldName
     * @param string $instruction
     * @param int $id
     */
    public function __construct(
        int $itemsInputId,
        string $localization,
        string $fieldName,
        string $instruction,
        int $id = 0
    )
    {
        $this->itemsInputId = $itemsInputId;
        $this->localization = $localization;
        $this->fieldName = $fieldName;
        $this->instruction = $instruction;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getItemsInputId(): int
    {
        return $this->itemsInputId;
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
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * @return string
     */
    public function getInstruction(): string
    {
        return $this->instruction;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
