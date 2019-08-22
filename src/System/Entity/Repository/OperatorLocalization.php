<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class OperatorLocalization
 * @package System\Entity\Repository
 */
class OperatorLocalization
{
    /**
     * @var int
     */
    private $operatorId;

    /**
     * @var string
     */
    private $localization;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $id;

    /**
     * OperatorLocalization constructor.
     * @param int $operatorId
     * @param string $localization
     * @param string $name
     * @param string $description
     * @param int $id
     */
    public function __construct(int $operatorId, string $localization, string $name, string $description, int $id = 0)
    {
        $this->operatorId = $operatorId;
        $this->localization = $localization;
        $this->name = $name;
        $this->description = $description;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getOperatorId(): int
    {
        return $this->operatorId;
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
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}