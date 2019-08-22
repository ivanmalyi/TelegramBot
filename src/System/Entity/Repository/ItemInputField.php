<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class ItemInputFields
 * @package System\Entity\Repository
 */
class ItemInputField
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
    private $prefix;

    /**
     * @var int
     */
    private $id;

    /**
     * ItemInputFields constructor.
     * @param int $itemId
     * @param int $order
     * @param int $minLength
     * @param int $maxLength
     * @param string $pattern
     * @param int $isMobile
     * @param int $typingStyle
     * @param string $prefix
     * @param int $id
     */
    public function __construct(
        int $itemId,
        int $order,
        int $minLength,
        int $maxLength,
        string $pattern,
        int $isMobile,
        int $typingStyle,
        string $prefix,
        int $id = 0
    )
    {
        $this->itemId = $itemId;
        $this->order = $order;
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
        $this->pattern = $pattern;
        $this->isMobile = $isMobile;
        $this->typingStyle = $typingStyle;
        $this->prefix = $prefix;
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
    public function getTypingStyle(): int
    {
        return $this->typingStyle;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getisMobile(): int
    {
        return $this->isMobile;
    }
}