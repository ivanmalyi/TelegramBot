<?php

namespace System\Util\Validation;

use System\Exception\Protocol\ValidationException;

/**
 * Class SimpleValidationResult
 * @package System\Util\Validation
 */
class SimpleValidationResult extends ValidationResult
{
    /**
     * Constructor
     *
     * @param boolean $booleanResult
     * @param string  $message
     * @param mixed   $variable
     */
    public function __construct($booleanResult, $message, $variable = null)
    {
        if ($booleanResult !== true) {
            parent::__construct(new ValidationException($message, $variable));
        }
    }
}
