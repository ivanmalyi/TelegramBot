<?php

declare(strict_types=1);

namespace System\Util\Validation;

/**
 * Class PositiveIntegerInRange
 * @package System\Util\Validation
 */
class PositiveIntegerInRange implements ValidatorInterface
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
     * @param int $min
     * @param int $max
     */
    public function __construct(int $min, int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * @param $value
     * @param array|null $mixed
     * @return SimpleValidationResult
     */
    public function validate($value, array $mixed = null)
    {
        return new SimpleValidationResult(
            $value !== null && is_int($value) && $value > 0 && $this->min <= $value && $this->max > $value,
            'Provided value must be positive integer and from '.$this->min.' to '.$this->max,
            $value
        );
    }
}
