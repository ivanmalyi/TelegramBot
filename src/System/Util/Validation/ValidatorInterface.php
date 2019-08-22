<?php

namespace System\Util\Validation;

/**
 * Interface ValidatorInterface
 * @package System\Util\Validation
 */
interface ValidatorInterface
{
    /**
     * Returns validation result according validator rules
     *
     * @param mixed $value
     * @param array $mixed
     * @return ValidationResultInterface
     */
    public function validate($value, array $mixed = null);
}
