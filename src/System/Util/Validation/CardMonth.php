<?php

declare(strict_types=1);

namespace System\Util\Validation;

/**
 * Class CardMonth
 * @package System\Util\Validation
 */
class CardMonth implements ValidatorInterface
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
            preg_match('/^[\d]{2}$/', $value) &&
            (int) $value > 0 and (int) $value < 13,
            'Variable must contain a number of a month'
        );
    }
}
