<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;
use System\Entity\Component\Billing\Display;


/**
 * Class VerifyResponse
 * @package System\Entity\Component\Billing\Response
 */
class VerifyResponse extends Response
{
    /**
     * @var int
     */
    private $chequeId;

    /**
     * @var int
     */
    private $psId;

    /**
     * @var int
     */
    private $status;

    /**
     * @var int
     */
    private $paymentSystemId;

    /**
     * @var Display|null
     */
    private $display;

    /**
     * @var ChequePrint[]|null
     */
    private $chequesPrint;

    /**
     * @var AcquiringCommission[]|null
     */
    private $acquiringCommissions;

    /**
     * @var int
     */
    private $itemId;

    /**
     * VerifyResponse constructor.
     * @param int $result
     * @param string $time
     * @param int $chequeId
     * @param int $psId
     * @param int $status
     * @param int $paymentSystemId
     * @param int $itemId
     */
    public function __construct(
        int $result,
        string $time,
        int $chequeId,
        int $psId,
        int $status,
        int $paymentSystemId,
        int $itemId = 0
    )
    {
        parent::__construct($result, $time);
        $this->chequeId = $chequeId;
        $this->psId = $psId;
        $this->status = $status;
        $this->paymentSystemId = $paymentSystemId;
        $this->itemId = $itemId;
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
    public function getPsId(): int
    {
        return $this->psId;
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
    public function getPaymentSystemId(): int
    {
        return $this->paymentSystemId;
    }

    /**
     * @return null|Display
     */
    public function getDisplay(): ?Display
    {
        return $this->display;
    }

    /**
     * @param null|Display $display
     */
    public function setDisplay(?Display $display): void
    {
        $this->display = $display;
    }

    /**
     * @return null|ChequePrint[]
     */
    public function getChequesPrint(): ?array
    {
        return $this->chequesPrint;
    }

    /**
     * @param null|ChequePrint[] $chequesPrint
     */
    public function setChequesPrint(?array $chequesPrint): void
    {
        $this->chequesPrint = $chequesPrint;
    }

    /**
     * @return null|AcquiringCommission[]
     */
    public function getAcquiringCommissions(): ?array
    {
        return $this->acquiringCommissions;
    }

    /**
     * @param null|AcquiringCommission[] $acquiringCommissions
     */
    public function setAcquiringCommissions(?array $acquiringCommissions): void
    {
        $this->acquiringCommissions = $acquiringCommissions;
    }

    /**
     * @return int
     */
    public function getItemId(): int
    {
        return $this->itemId;
    }

    /**
     * @param int $result
     * @return VerifyResponse
     */
    public static function buildWhenError(int $result): self
    {
        return new self(
            $result,
            date('Y-m-d H:i:s'),
            0,
            0,
            0,
            0
        );
    }
}