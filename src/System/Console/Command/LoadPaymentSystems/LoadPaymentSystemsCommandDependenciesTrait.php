<?php

declare(strict_types=1);

namespace System\Console\Command\LoadPaymentSystems;

use System\Exception\DiException;
use System\Repository\PaymentSystems\PaymentSystemsRepositoryInterface;
use System\Repository\PaymentSystemsHeadersLocalization\PaymentSystemsHeadersLocalizationRepositoryInterface;

trait LoadPaymentSystemsCommandDependenciesTrait
{
    /**
     * @var PaymentSystemsRepositoryInterface
     */
    private $paymentSystemsRepository;

    /**
     * @var PaymentSystemsHeadersLocalizationRepositoryInterface
     */
    private $paymentSystemsHeadersLocalizationRepository;

    /**
     * @return PaymentSystemsRepositoryInterface
     * @throws DiException
     */
    public function getPaymentSystemsRepository(): PaymentSystemsRepositoryInterface
    {
        if ($this->paymentSystemsRepository === null) {
            throw new DiException('PaymentSystemsRepository');
        }
        return $this->paymentSystemsRepository;
    }

    /**
     * @param PaymentSystemsRepositoryInterface $paymentSystemsRepository
     */
    public function setPaymentSystemsRepository(PaymentSystemsRepositoryInterface $paymentSystemsRepository): void
    {
        $this->paymentSystemsRepository = $paymentSystemsRepository;
    }

    /**
     * @return PaymentSystemsHeadersLocalizationRepositoryInterface
     * @throws DiException
     */
    public function getPaymentSystemsHeadersLocalizationRepository(): PaymentSystemsHeadersLocalizationRepositoryInterface
    {
        if ($this->paymentSystemsRepository === null) {
            throw new DiException('PaymentSystemsLocalizationRepository');
        }
        return $this->paymentSystemsHeadersLocalizationRepository;
    }

    /**
     * @param PaymentSystemsHeadersLocalizationRepositoryInterface $paymentSystemsHeadersLocalizationRepository
     */
    public function setPaymentSystemsHeadersLocalizationRepository(PaymentSystemsHeadersLocalizationRepositoryInterface $paymentSystemsHeadersLocalizationRepository): void
    {
        $this->paymentSystemsHeadersLocalizationRepository = $paymentSystemsHeadersLocalizationRepository;
    }
}
