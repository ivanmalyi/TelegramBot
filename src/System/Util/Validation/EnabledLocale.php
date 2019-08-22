<?php

declare(strict_types=1);

namespace System\Util\Validation;

use System\Entity\InternalProtocol\Locale;

/**
 * Class EnabledLocale
 * @package System\Util\Validation
 */
class EnabledLocale implements ValidatorInterface
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
            $value !== null && is_string($value) && Locale::isLocaleExist($value),
            sprintf('Unsupported locale: %s', $value ?? ''),
            $value
        );
    }
}
