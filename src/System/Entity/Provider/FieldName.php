<?php

declare(strict_types=1);

namespace System\Entity\Provider;


/**
 * Class FieldName
 * @package System\Entity\Provider
 */
class FieldName
{
    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $fieldName;

    /**
     * @var string
     */
    private $instruction;

    /**
     * FieldName constructor.
     * @param string $language
     * @param string $fieldName
     * @param string $instruction
     */
    public function __construct(string $language, string $fieldName, string $instruction)
    {
        $this->language = $language;
        $this->fieldName = $fieldName;
        $this->instruction = $instruction;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
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
}