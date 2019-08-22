<?php

namespace System\Util\Validation;

class IntegerInRange implements ValidatorInterface
{
    /**
     * @var int
     */
    private $min;

    /**
     * @var int
     */
    private $max;

    /**
     * PositiveIntegerInRange constructor.
     * @param $min
     * @param $max
     */
    public function __construct(int $min, int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Returns validation result according validator rules
     *
     * @param mixed $value
     * @param array $mixed
     * @return ValidationResultInterface
     */
    public function validate($value, array $mixed = null)
    {
        return new SimpleValidationResult(
            $value !== null && is_int($value) && $value >= $this->min && $value <= $this->max,
            sprintf('Provided value must be integer in range from %d to %d', $this->min, $this->max),
            $value
        );
    }
}
