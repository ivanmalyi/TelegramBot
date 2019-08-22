<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;


/**
 * Class LoadInformationResponse
 * @package System\Entity\Component\Billing\Response
 */
class LoadInformationResponse  extends Response
{
    /**
     * @var int
     */
    private $memberId;

    /**
     * @var int
     */
    private $id;

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
     * LoadInformationResponse constructor.
     * @param int $result
     * @param string $time
     * @param int $memberId
     * @param int $id
     * @param string $address
     * @param string $place
     * @param string $addInfo
     */
    public function __construct(
        int $result,
        string $time,
        int $memberId,
        int $id,
        string $address,
        string $place,
        string $addInfo
    )
    {
        parent::__construct($result, $time);
        $this->memberId = $memberId;
        $this->id = $id;
        $this->address = $address;
        $this->place = $place;
        $this->addInfo = $addInfo;
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
    public function getId(): int
    {
        return $this->id;
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
     * @param int $result
     * @return LoadInformationResponse
     */
    public static function buildWhenError(int $result): self
    {
        return new self($result, date('Y-m-d H:i:s'), 0, 0, '', '', '');
    }
}