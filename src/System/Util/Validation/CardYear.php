<?php

declare(strict_types=1);

namespace System\Util\Validation;

/**
 * Class CardYear
 * @package System\Util\Validation
 */
class CardYear implements ValidatorInterface
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
            preg_match('/^[\d]{2}$/', $value),
            'Variable must contain last two numbers of a year'
        );
    }
}
