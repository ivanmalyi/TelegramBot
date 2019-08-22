<?php

declare(strict_types=1);

namespace System\Console\Command\PaymentPurpose;
use System\Exception\DiException;
use System\Repository\PaymentsPurpose\PaymentsPurposeRepositoryInterface;


/**
 * Trait PaymentPurposeCommandDependenciesTrait
 * @package System\Console\Command\PaymentPurpose
 */
trait PaymentPurposeCommandDependenciesTrait
{
    /**
     * @var PaymentsPurposeRepositoryInterface
     */
    private $paymentsPurposeRepository;

    /**
     * @return PaymentsPurposeRepositoryInterface
     *
     * @throws DiException
     */
    public function getPaymentsPurposeRepository(): PaymentsPurposeRepositoryInterface
    {
        if ($this->paymentsPurposeRepository === null) {
            throw new DiException('PaymentsPurposeRepository');
        }
        return $this->paymentsPurposeRepository;
    }

    /**
     * @param PaymentsPurposeRepositoryInterface $paymentsPurposeRepository
     */
    public function setPaymentsPurposeRepository(PaymentsPurposeRepositoryInterface $paymentsPurposeRepository): void
    {
        $this->paymentsPurposeRepository = $paymentsPurposeRepository;
    }
}