<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;

use System\Entity\Repository\PaymentSystem;
use System\Entity\Repository\PaymentSystemHeaderLocalization;

/**
 * Class LoadPaymentSystemsResponse
 * @package System\Entity\Component\Billing\Response
 */
class LoadPaymentSystemsResponse extends Response
{
    /**
     * @var PaymentSystem[]
     */
    private $paymentSystems;

    /**
     * @var PaymentSystemHeaderLocalization[]
     */
    private $paymentSystemHeaderLocalizations;

    /**
     * LoadPaymentSystemsResponse constructor.
     *
     * @param int $result
     * @param PaymentSystem[] $paymentSystems
     * @param array $paymentSystemHeaderLocalizations
     * @param string $time
     */
    public function __construct(int $result, array $paymentSystems, array $paymentSystemHeaderLocalizations, string $time)
    {
        parent::__construct($result, $time);
        $this->paymentSystems = $paymentSystems;
        $this->paymentSystemHeaderLocalizations = $paymentSystemHeaderLocalizations;
    }

    /**
     * @return PaymentSystem[]
     */
    public function getPaymentSystems(): array
    {
        return $this->paymentSystems;
    }

    /**
     * @return PaymentSystemHeaderLocalization[]
     */
    public function getPaymentSystemHeaderLocalizations(): array
    {
        return $this->paymentSystemHeaderLocalizations;
    }

    /**
     * @param int $result
     * @return LoadPaymentSystemsResponse
     */
    public static function buildWhenError(int $result): self
    {
        return new self($result, [], [], date('Y-m-d H:i:s'));
    }
}
