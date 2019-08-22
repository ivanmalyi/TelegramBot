<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class PaymentPrintData
 * @package System\Entity\Repository
 */
class PaymentPrintData
{
    /**
     * @var int
     */
    private $paymentId;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $target;

    /**
     * @var int
     */
    private $id;

    /**
     * PaymentPrintData constructor.
     * @param int $paymentId
     * @param string $text
     * @param string $value
     * @param string $target
     * @param int $id
     */
    public function __construct(int $paymentId, string $text, string $value, string $target, int $id = 0)
    {
        $this->paymentId = $paymentId;
        $this->text = $text;
        $this->value = $value;
        $this->target = $target;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getPaymentId(): int
    {
        return $this->paymentId;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
