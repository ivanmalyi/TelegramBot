<?php

declare(strict_types=1);

namespace System\Entity\Provider;


/**
 * Class InputField
 * @package System\Entity\Provider
 */
class InputField
{
    /**
     * @var int
     */
    private $itemId;

    /**
     * @var int
     */
    private $order;

    /**
     * @var int
     */
    private $minLength;

    /**
     * @var int
     */
    private $maxLength;

    /**
     * @var string
     */
    private $pattern;

    /**
     * @var int
     */
    private $isMobile;

    /**
     * @var int
     */
    private $typingStyle;

    /**
     * @var string
     */
    private $prefixes;

    /**
     * @var FieldName[]
     */
    private $fieldNames;

    /**
     * InputField constructor.
     * @param int $itemId
     * @param int $order
     * @param int $minLength
     * @param int $maxLength
     * @param string $pattern
     * @param int $isMobile
     * @param int $typingStyle
     * @param string $prefixes
     * @param InputField[] $inputFields
     */
    public function __construct(
        int $itemId,
        int $order,
        int $minLength,
        int $maxLength,
        string $pattern,
        int $isMobile,
        int $typingStyle,
        string $prefixes
    )
    {
        $this->itemId = $itemId;
        $this->order = $order;
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
        $this->pattern = $pattern;
        $this->isMobile = $isMobile;
        $this->typingStyle = $typingStyle;
        $this->prefixes = $prefixes;
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
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @return int
     */
    public function getMinLength(): int
    {
        return $this->minLength;
    }

    /**
     * @return int
     */
    public function getMaxLength(): int
    {
        return $this->maxLength;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @return int
     */
    public function getisMobile(): int
    {
        return $this->isMobile;
    }

    /**
     * @return int
     */
    public function getTypingStyle(): int
    {
        return $this->typingStyle;
    }

    /**
     * @return string
     */
    public function getPrefixes(): string
    {
        return $this->prefixes;
    }

    /**
     * @return FieldName[]
     */
    public function getFieldNames(): array
    {
        return $this->fieldNames;
    }

    /**
     * @param FieldName[] $fieldNames
     */
    public function setFieldNames(array $fieldNames): void
    {
        $this->fieldNames = $fieldNames;
    }
}