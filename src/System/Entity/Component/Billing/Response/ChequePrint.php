<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;


use System\Util\ConverterClass\ToArrayTrait;

class ChequePrint
{
    use ToArrayTrait;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $target;

    /**
     * ChequePrint constructor.
     * @param string $text
     * @param string $value
     * @param string $target
     */
    public function __construct(string $text, string $value, string $target)
    {
        $this->text = $text;
        $this->value = $value;
        $this->target = $target;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
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
    public function getTarget(): string
    {
        return $this->target;
    }
}