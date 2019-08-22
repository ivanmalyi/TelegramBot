<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing;

/**
 * Class LocalizationData
 * @package System\Entity\Component\Billing
 */
class LocalizationData
{
    const UA = 'UA';
    const RU = 'RU';
    const EN = 'EN';

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $text;

    /**
     * SectionName constructor.
     * @param string $language
     * @param string $text
     */
    public function __construct(string $language, string $text)
    {
        $this->language = $language;
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getLanguage() : string
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getText() : string
    {
        return $this->text;
    }
}
