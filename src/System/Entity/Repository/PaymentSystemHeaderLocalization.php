<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class PaymentSystemLocalization
 * @package System\Entity\Repository
 */
class PaymentSystemHeaderLocalization
{
    /**
     * @var int
     */
    private $paymentSystemId;

    /**
     * @var string
     */
    private $localization;

    /**
     * @var string
     */
    private $text;

    /**
     * @var int
     */
    private $id;

    /**
     * PaymentSystemLocalization constructor.
     * @param int $paymentSystemId
     * @param string $localization
     * @param string $text
     * @param int $id
     */
    public function __construct(int $paymentSystemId, string $localization, string $text, int $id = 0)
    {
        $this->paymentSystemId = $paymentSystemId;
        $this->localization = $localization;
        $this->text = $text;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getPaymentSystemId(): int
    {
        return $this->paymentSystemId;
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
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
