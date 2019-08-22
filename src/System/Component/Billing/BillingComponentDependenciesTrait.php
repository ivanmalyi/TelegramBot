<?php

declare(strict_types=1);

namespace System\Component\Billing;


use System\Component\SecurityComponentInterface;
use System\Exception\DiException;
use System\Repository\BillingSettings\BillingSettingsRepositoryInterface;
use System\Util\Http\HttpClientInterface;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Trait BillingComponentDependenciesTrait
 * @package System\Component\Billing
 */
trait BillingComponentDependenciesTrait
{
    use LoggerReferenceTrait;

    /**
     * @var BillingSettingsRepositoryInterface
     */
    private $billingSettingsRepository;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var SecurityComponentInterface
     */
    private $openSslSecurityComponent;

    /**
     * @return BillingSettingsRepositoryInterface
     * @throws DiException
     */
    public function getBillingSettingsRepository(): BillingSettingsRepositoryInterface
    {
        if (null === $this->billingSettingsRepository) {
            throw new DiException('BillingSettingsRepositorys');
        }

        return $this->billingSettingsRepository;
    }

    /**
     * @param BillingSettingsRepositoryInterface $billingSettingsRepository
     */
    public function setBillingSettingsRepository(BillingSettingsRepositoryInterface $billingSettingsRepository): void
    {
        $this->billingSettingsRepository = $billingSettingsRepository;
    }

    /**
     * @return HttpClientInterface
     * @throws DiException
     */
    public function getHttpClient(): HttpClientInterface
    {
        if (null === $this->httpClient) {
            throw new DiException('HttpClient');
        }
        return $this->httpClient;
    }

    /**
     * @param HttpClientInterface $httpClient
     */
    public function setHttpClient(HttpClientInterface $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return SecurityComponentInterface
     * @throws DiException
     */
    public function getOpenSslSecurityComponent(): SecurityComponentInterface
    {
        if (null === $this->openSslSecurityComponent) {
            throw new DiException('OpenSslSecurityComponent');
        }

        return $this->openSslSecurityComponent;
    }

    /**
     * @param SecurityComponentInterface $openSslSecurityComponent
     */
    public function setOpenSslSecurityComponent(SecurityComponentInterface $openSslSecurityComponent): void
    {
        $this->openSslSecurityComponent = $openSslSecurityComponent;
    }
}