<?php

namespace System\Util\Validation;

/**
 * Class NotEmptyString
 * @package System\Util\Validation
 */
class NotEmptyString implements ValidatorInterface
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
            $value !== null && is_string($value) && strlen(trim($value)) > 0,
            'Variable must contain not empty and not zerofill string'
        );
    }
}
