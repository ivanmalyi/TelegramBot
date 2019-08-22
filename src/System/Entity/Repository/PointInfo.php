<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class PointInfo
 * @package System\Entity\Repository
 */
class PointInfo
{
    /**
     * @var int
     */
    private $memberId;

    /**
     * @var int
     */
    private $pointId;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $place;

    /**
     * @var string
     */
    private $addInfo;

    /**
     * @var int
     */
    private $id;

    /**
     * PointInfo constructor.
     * @param int $memberId
     * @param int $pointId
     * @param string $address
     * @param string $place
     * @param string $addInfo
     * @param int $id
     */
    public function __construct(
        int $memberId,
        int $pointId,
        string $address,
        string $place,
        string $addInfo,
        int $id
    )
    {
        $this->memberId = $memberId;
        $this->pointId = $pointId;
        $this->address = $address;
        $this->place = $place;
        $this->addInfo = $addInfo;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getMemberId(): int
    {
        return $this->memberId;
    }

    /**
     * @return int
     */
    public function getPointId(): int
    {
        return $this->pointId;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getPlace(): string
    {
        return $this->place;
    }

    /**
     * @return string
     */
    public function getAddInfo(): string
    {
        return $this->addInfo;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}