<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;

use System\Entity\Repository\PaymentPurpose;


/**
 * Class PaymentPurposeResponse
 * @package System\Entity\Component\Billing\Response
 */
class PaymentPurposeResponse extends Response
{
    /**
     * @var PaymentPurpose[]
     */
    private $paymentsPurpose;

    /**
     * PaymentPurposeResponse constructor.
     * @param int $result
     * @param string $time
     * @param array $paymentsPurpose
     */
    public function __construct(int $result, string $time, array $paymentsPurpose)
    {
        parent::__construct($result, $time);
        $this->paymentsPurpose = $paymentsPurpose;
    }

    /**
     * @return PaymentPurpose[]
     */
    public function getPaymentsPurpose(): array
    {
        return $this->paymentsPurpose;
    }

    /**
     * @param int $result
     *
     * @return PaymentPurposeResponse
     */
    public static function buildWhenError(int $result): self
    {
        return new self($result, date('Y-m-d H:i:s'), []);
    }
}