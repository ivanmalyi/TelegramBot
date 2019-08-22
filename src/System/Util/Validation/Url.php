<?php

declare(strict_types=1);

namespace System\Util\Validation;

/**
 * Class Url
 * @package System\Util\Validation
 */
class Url implements ValidatorInterface
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
            preg_match('/^http(s)?:\/\//', $value) === 1 &&
            filter_var($value, FILTER_VALIDATE_URL) !== false,
            'Variable must contain not empty and url address'
        );
    }
}
