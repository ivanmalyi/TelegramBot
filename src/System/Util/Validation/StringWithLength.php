<?php

declare(strict_types=1);

namespace System\Util\Validation;

/**
 * Class StringWithLength
 * @package System\Util\Validation
 */
class StringWithLength implements ValidatorInterface
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
            $value !== null && is_string($value) && strlen(trim($value)) == 16,
            'Variable must contain not empty and not zerofill string'
        );
    }
}
