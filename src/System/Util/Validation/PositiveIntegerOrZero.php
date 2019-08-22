<?php

namespace System\Util\Validation;

/**
 * Class PositiveIntegerOrZero
 * @package System\Util\Validation
 */
class PositiveIntegerOrZero implements ValidatorInterface
{
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
            $value !== null && is_int($value) && $value >= 0,
            'Provided value must be positive integer',
            $value
        );
    }
}
