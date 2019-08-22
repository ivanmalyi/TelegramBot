<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class RecipientTemplate
 * @package System\Entity\Repository
 */
class RecipientTemplate
{
    /**
     * @var int
     */
    private $templateId;

    /**
     * @var string
     */
    private $localization;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $id;

    /**
     * RecipientTemplate constructor.
     * @param int $templateId
     * @param string $localization
     * @param string $name
     * @param int $id
     */
    public function __construct(int $templateId, string $localization, string $name, int $id = 0)
    {
        $this->templateId = $templateId;
        $this->localization = $localization;
        $this->name = $name;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getTemplateId(): int
    {
        return $this->templateId;
    }

    /**
     * @return string
     */
    public function getLocalization(): string
    {
        return $this->localization;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
