<?php

declare(strict_types=1);

namespace System\Util\Validation;

class ArrayHasKeysWithTypes implements ValidatorInterface
{
    /**
     * @var array
     */
    private $keys;

    /**
     * HasKeysWithTypes constructor.
     * @param array $keys
     */
    public function __construct(array $keys = [])
    {
        $this->keys = $keys;
    }

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
            $value !== null &&
            is_array($value) &&
            count($value) > 0 &&
            $this->isInstanceOfBasket($value),
            'Variable must contain not empty array'
        );
    }

    private function isInstanceOfBasket(array $data)
    {
        foreach ($this->keys as $key => $value) {
            if (!isset($data[$key]) || gettype($data[$key]) !== $value) {
                return false;
            }
        }
        return true;
    }
}
