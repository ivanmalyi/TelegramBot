<?php

declare(strict_types=1);

namespace System\Util\Validation;

class BooleanArgument implements ValidatorInterface
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
            $value !== null && is_bool($value),
            'Variable must be boolean'
        );
    }
}
