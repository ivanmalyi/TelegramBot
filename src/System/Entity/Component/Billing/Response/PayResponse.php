<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;

use System\Entity\Component\Billing\Display;

/**
 * Class PayResponse
 * @package System\Entity\Component\Billing\Response
 */
class PayResponse extends Response
{
    /**
     * @var int
     */
    private $status;

    /**
     * @var int
     */
    private $chequeId;

    /**
     * @var int
     */
    private $paymentId;

    /**
     * @var int
     */
    private $acquiringStatus;

    /**
     * @var string
     */
    private $acquiringConfirmUrl;

    /**
     * @var int
     */
    private $acquiringTransactionId;

    /**
     * @var string
     */
    private $acquiringMerchantId;

    /**
     * @var int
     */
    private $psId;

    /**
     * @var int
     */
    private $operatorPayId;

    /**
     * @var int
     */
    private $operatorChequeId;

    /**
     * @var ChequePrint[]
     */
    private $print;

    /**
     * @var Display
     */
    private $display;

    /**
     * PayResponse constructor.
     * @param int $result
     * @param string $time
     * @param int $status
     * @param int $chequeId
     * @param int $paymentId
     * @param int $acquiringStatus
     * @param int $acquiringTransactionId
     * @param string $acquiringMerchantId
     * @param string $acquiringConfirmUrl
     * @param int $psId
     * @param int $operatorPayId
     * @param int $operatorChequeId
     */
    public function __construct(
        int $result,
        string $time,
        int $status,
        int $chequeId,
        int $paymentId,
        int $acquiringStatus,
        int $acquiringTransactionId,
        string $acquiringMerchantId,
        string $acquiringConfirmUrl = '',
        int $psId = 0,
        int $operatorPayId = 0,
        int $operatorChequeId = 0
    )
    {
        parent::__construct($result, $time);
        $this->status = $status;
        $this->chequeId = $chequeId;
        $this->paymentId = $paymentId;
        $this->acquiringStatus = $acquiringStatus;
        $this->acquiringConfirmUrl = $acquiringConfirmUrl;
        $this->acquiringTransactionId = $acquiringTransactionId;
        $this->acquiringMerchantId = $acquiringMerchantId;
        $this->psId = $psId;
        $this->operatorPayId = $operatorPayId;
        $this->operatorChequeId = $operatorChequeId;
        $this->print = [];
        $this->display = null;
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
    public function getChequeId(): int
    {
        return $this->chequeId;
    }

    /**
     * @return int
     */
    public function getPaymentId(): int
    {
        return $this->paymentId;
    }

    /**
     * @return int
     */
    public function getAcquiringStatus(): int
    {
        return $this->acquiringStatus;
    }

    /**
     * @return string
     */
    public function getAcquiringConfirmUrl(): string
    {
        return $this->acquiringConfirmUrl;
    }

    /**
     * @return int
     */
    public function getAcquiringTransactionId(): int
    {
        return $this->acquiringTransactionId;
    }

    /**
     * @return string
     */
    public function getAcquiringMerchantId(): string
    {
        return $this->acquiringMerchantId;
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
    public function getOperatorPayId(): int
    {
        return $this->operatorPayId;
    }

    /**
     * @return int
     */
    public function getOperatorChequeId(): int
    {
        return $this->operatorChequeId;
    }

    /**
     * @return ChequePrint[]
     */
    public function getPrint(): array
    {
        return $this->print;
    }

    /**
     * @param ChequePrint[] $print
     */
    public function setPrint(array $print): void
    {
        $this->print = $print;
    }

    /**
     * @return null|Display
     */
    public function getDisplay(): ?Display
    {
        return $this->display;
    }

    /**
     * @param Display $display
     */
    public function setDisplay(Display $display): void
    {
        $this->display = $display;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $data = [];

        foreach ($this as $key => $value) {
            if ($key === 'display' and $value !== null) {
                /** @var Display $value */
                $data[$key] = $value->toArray();
            } elseif ($key === 'print' and !empty($value)) {
                $data[$key] = [];
                /** @var ChequePrint[] $value */
                foreach ($value as $chequePrint) {
                    $data[$key][] = $chequePrint->toArray();
                }
            } else {
                $data[$key] = $value;
            }
        }

        return (string) json_encode($data);
    }

    /**
     * @param int $result
     * @return GetPaymentPageResponse
     */
    public static function buildWhenError(int $result): self
    {
        return new self(
            $result,
            date('Y-m-d H:i:s'),
            0,
            0,
            0,
            0,
            0,
            ''
        );
    }
}
