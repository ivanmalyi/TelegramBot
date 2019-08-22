<?php

declare(strict_types=1);

namespace System\Util\Validation;

/**
 * Class StringLengthInRange
 * @package System\Util\Validation
 */
class StringLengthInRange implements ValidatorInterface
{
    /**
     * @var array
     */
    private $allowableLengths;

    /**
     * StringLengthInRange constructor.
     * @param array $allowableLengths
     */
    public function __construct(array $allowableLengths)
    {
        $this->allowableLengths = $allowableLengths;
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
            $value !== null && is_string($value) && in_array(strlen(trim($value)), $this->allowableLengths),
            'Variable must contain not empty and not zerofill string'
        );
    }
}
