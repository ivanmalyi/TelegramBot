<?php

declare(strict_types=1);

namespace System\Exception\Protocol;

/**
 * Class ValidationException
 * @package System\Exception
 */
class ValidationException extends \InvalidArgumentException
{
    /**
     * @var mixed|null
     */
    private $variableValue;

    /**
     * Constructor
     *
     * @param string $message
     * @param mixed $variableValue
     */
    public function __construct($message, $variableValue = null)
    {
        parent::__construct($message);
        $this->variableValue = $variableValue;
    }

    /**
     * Returns value of variable
     *
     * @return mixed|null
     */
    public function getVariableValue()
    {
        return $this->variableValue;
    }
}
