<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class Button
 * @package System\Entity\Repository
 */
class Button
{
    /**
     * @var string
     */
    private $callBackAction;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $buttonType;

    /**
     * @var int
     */
    private $id;

    /**
     * Button constructor.
     * @param string $callBackAction
     * @param string $name
     * @param string $value
     * @param string $buttonType
     * @param int $id
     */
    public function __construct(string $callBackAction, string $name, string $value, string $buttonType, int $id = 0)
    {
        $this->callBackAction = $callBackAction;
        $this->name = $name;
        $this->value = $value;
        $this->buttonType = $buttonType;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCallBackAction(): string
    {
        return $this->callBackAction;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getButtonType(): string
    {
        return $this->buttonType;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}