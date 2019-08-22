<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol;

/**
 * Class Locale
 * @package System\Entity\InternalProtocol
 */
class Locale
{
    /**
     * Russian locale
     */
    const RU = 'ru';
    /**
     * Ukrainian locale
     */
    const UA = 'ua';
    /**
     * English locale
     */
    const EN = 'en';

    /**
     * @param string $locale
     * @return bool
     */
    public static function isLocaleExist(string $locale): bool
    {
        return in_array($locale, [self::UA, self::RU, self::EN]);
    }
}
