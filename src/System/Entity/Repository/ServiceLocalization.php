<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class ServiceLocalization
 * @package System\Entity\Repository
 */
class ServiceLocalization
{
    /**
     * @var int
     */
    private $serviceId;

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
     * ServiceLocalization constructor.
     * @param int $serviceId
     * @param string $localization
     * @param string $name
     * @param int $id
     */
    public function __construct(int $serviceId, string $localization, string $name, int $id = 0)
    {
        $this->serviceId = $serviceId;
        $this->localization = $localization;
        $this->name = $name;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getServiceId(): int
    {
        return $this->serviceId;
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