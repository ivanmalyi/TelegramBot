<?php

namespace System\Util\Validation;

/**
 * Class AnyString
 * @package System\Util\Validation
 */
class AnyString implements ValidatorInterface
{
    /**
     * Returns validation result according validator rules
     * @param mixed $value
     * @param array|null $mixed
     * @return SimpleValidationResult
     */
    public function validate($value, array $mixed = null) : SimpleValidationResult
    {
        return new SimpleValidationResult(
            $value !== null && is_string($value),
            'Variable must contain any string'
        );
    }
}
