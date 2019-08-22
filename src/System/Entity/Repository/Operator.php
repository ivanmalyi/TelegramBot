<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class Operator
 * @package System\Entity\Repository
 */
class Operator
{
    /**
     * @var int
     */
    private $sectionId;

    /**
     * @var string
     */
    private $image;

    /**
     * @var int
     */
    private $status;

    /**
     * @var int
     */
    private $id;

    /**
     * Operator constructor.
     * @param int $sectionId
     * @param string $image
     * @param int $status
     * @param int $id
     */
    public function __construct(int $sectionId, string $image, int $status, int $id = 0)
    {
        $this->sectionId = $sectionId;
        $this->image = $image;
        $this->status = $status;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getSectionId(): int
    {
        return $this->sectionId;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}