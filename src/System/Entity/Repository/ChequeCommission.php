<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class ChequeCommission
 * @package System\Entity\Repository
 */
class ChequeCommission
{
    /**
     * @var int
     */
    private $chequeId;

    /**
     * @var int
     */
    private $commissionId;

    /**
     * @var int
     */
    private $itemId;

    /**
     * @var int
     */
    private $id;

    /**
     * ChequeCommission constructor.
     * @param int $chequeId
     * @param int $commissionId
     * @param int $itemId
     * @param int $id
     */
    public function __construct(int $chequeId, int $commissionId, int $itemId, int $id = 0)
    {
        $this->chequeId = $chequeId;
        $this->commissionId = $commissionId;
        $this->itemId = $itemId;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getChequeId(): int
    {
        return $this->chequeId;
    }

    /**
     * @return int
     */
    public function getCommissionId(): int
    {
        return $this->commissionId;
    }

    /**
     * @return int
     */
    public function getItemId(): int
    {
        return $this->itemId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
