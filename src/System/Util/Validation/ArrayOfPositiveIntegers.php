<?php

declare(strict_types=1);

namespace System\Util\Validation;


class ArrayOfPositiveIntegers implements ValidatorInterface
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
            $value !== null && is_array($value) && !empty($value) && $this->isArrayOfIntegers($value),
            'Variable must contain not empty array of integers'
        );
    }

    /**
     * @param array $data
     * @return bool
     */
    private function isArrayOfIntegers(array $data) : bool
    {
        foreach ($data as $value) {
            if (!is_int($value)) {
                return false;
            }
        }
        return true;
    }
}