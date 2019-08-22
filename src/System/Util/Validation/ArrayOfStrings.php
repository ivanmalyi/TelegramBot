<?php

declare(strict_types=1);

namespace System\Util\Validation;

class ArrayOfStrings implements ValidatorInterface
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
            $value !== null && is_array($value) && $this->isArrayOfStrings($value),
            'Variable must contain not empty array of strings'
        );
    }

    /**
     * @param array $data
     * @return bool
     */
    private function isArrayOfStrings(array $data) : bool
    {
        foreach ($data as $value) {
            if (!is_string($value)) {
                return false;
            }
        }
        return true;
    }
}
