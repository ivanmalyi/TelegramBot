<?php

declare(strict_types=1);

namespace System\Util\Validation;

/**
 * Class EmailFormatString
 * @package System\Util\Validation
 */
class EmailStringFormat implements ValidatorInterface
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
            $value !== null && is_string($value) &&
            filter_var($value, FILTER_VALIDATE_EMAIL) !== false,
            'Variable must contain not empty and valid email address'
        );
    }
}
