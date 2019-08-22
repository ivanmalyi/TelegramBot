<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class Service
 * @package System\Entity\Repository
 */
class Service
{
    /**
     * @var int
     */
    private $operatorId;

    /**
     * @var int
     */
    private $serviceTypeId;

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
     * Service constructor.
     * @param int $operatorId
     * @param int $serviceTypeId
     * @param string $image
     * @param int $status
     * @param int $id
     */
    public function __construct(int $operatorId, int $serviceTypeId, string $image, int $status, int $id = 0)
    {
        $this->operatorId = $operatorId;
        $this->serviceTypeId = $serviceTypeId;
        $this->image = $image;
        $this->status = $status;
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
     * @return int
     */
    public function getServiceTypeId(): int
    {
        return $this->serviceTypeId;
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