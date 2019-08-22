<?php

declare(strict_types=1);

namespace System\Util\Validation;

class SimpleArrayOfPositiveIntegers implements ValidatorInterface
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
            $value !== null && is_array($value) && $this->isArrayOfPositiveIntegers($value),
            'Variable must contain empty array or array of positive integers'
        );
    }

    /**
     * @param array $data
     * @return bool
     */
    private function isArrayOfPositiveIntegers(array $data) : bool
    {
        foreach ($data as $value) {
            if (!is_int($value) or $value <= 0) {
                return false;
            }
        }
        return true;
    }
}
