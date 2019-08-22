<?php

declare(strict_types=1);

namespace System\Console\Command\LoadOperators;

use System\Exception\DiException;
use System\Repository\BillingSettings\BillingSettingsRepositoryInterface;
use System\Repository\Items\ItemsRepositoryInterface;
use System\Repository\ItemsInputFields\ItemsInputFieldsRepositoryInterface;
use System\Repository\ItemsInputFieldsLocalization\ItemsInputFieldsLocalizationRepositoryInterface;
use System\Repository\ItemsLocalization\ItemsLocalizationRepositoryInterface;
use System\Repository\ItemTypes\ItemTypesRepositoryInterface;
use System\Repository\MccCodes\MccCodesRepositoryInterface;
use System\Repository\Operators\OperatorsRepositoryInterface;
use System\Repository\OperatorsLocalization\OperatorsLocalizationRepositoryInterface;
use System\Repository\Sections\SectionsRepositoryInterface;
use System\Repository\Services\ServicesRepositoryInterface;
use System\Repository\ServicesLocalization\ServicesLocalizationRepositoryInterface;

/**
 * Trait LoadOperatorsCommandDependenciesTrait
 * @package System\Console\Command\LoadOperators
 */
trait LoadOperatorsCommandDependenciesTrait
{
    /**
     * @var SectionsRepositoryInterface
     */
    private $sectionsRepository;

    /**
     * @var OperatorsRepositoryInterface
     */
    private $operatorsRepository;

    /**
     * @var ServicesRepositoryInterface
     */
    private $servicesRepository;

    /**
     * @var ItemsRepositoryInterface
     */
    private $itemsRepository;

    /**
     * @var ItemsInputFieldsRepositoryInterface
     */
    private $itemsInputFieldsRepository;

    /**
     * @var ItemsInputFieldsLocalizationRepositoryInterface
     */
    private $itemsInputFieldsLocalizationRepository;

    /**
     * @var ItemsLocalizationRepositoryInterface
     */
    private $itemsLocalizationRepository;

    /**
     * @var ItemTypesRepositoryInterface
     */
    private $itemTypesRepository;

    /**
     * @var ServicesLocalizationRepositoryInterface
     */
    private $servicesLocalizationRepository;

    /**
     * @var OperatorsLocalizationRepositoryInterface
     */
    private $operatorsLocalizationRepository;

    /**
     * @var BillingSettingsRepositoryInterface
     */
    private $billingSettingsRepository;

    /**
     * @var MccCodesRepositoryInterface
     */
    private $mccCodesRepository;

    /**
     * @return SectionsRepositoryInterface
     * @throws DiException
     */
    public function getSectionsRepository(): SectionsRepositoryInterface
    {
        if (null === $this->sectionsRepository) {
            throw new DiException('SectionsRepository');
        }

        return $this->sectionsRepository;
    }

    /**
     * @param SectionsRepositoryInterface $sectionsRepository
     */
    public function setSectionsRepository(SectionsRepositoryInterface $sectionsRepository): void
    {
        $this->sectionsRepository = $sectionsRepository;
    }

    /**
     * @return OperatorsRepositoryInterface
     * @throws DiException
     */
    public function getOperatorsRepository(): OperatorsRepositoryInterface
    {
        if (null === $this->operatorsRepository) {
            throw new DiException('OperatorsRepository');
        }

        return $this->operatorsRepository;
    }

    /**
     * @param OperatorsRepositoryInterface $operatorsRepository
     */
    public function setOperatorsRepository(OperatorsRepositoryInterface $operatorsRepository): void
    {
        $this->operatorsRepository = $operatorsRepository;
    }

    /**
     * @return ServicesRepositoryInterface
     * @throws DiException
     */
    public function getServicesRepository(): ServicesRepositoryInterface
    {
        if (null === $this->servicesRepository) {
            throw new DiException('ServicesRepository');
        }

        return $this->servicesRepository;
    }

    /**
     * @param ServicesRepositoryInterface $servicesRepository
     */
    public function setServicesRepository(ServicesRepositoryInterface $servicesRepository): void
    {
        $this->servicesRepository = $servicesRepository;
    }

    /**
     * @return ItemsRepositoryInterface
     * @throws DiException
     */
    public function getItemsRepository(): ItemsRepositoryInterface
    {
        if (null === $this->itemsRepository) {
            throw new DiException('ItemsRepository');
        }

        return $this->itemsRepository;
    }

    /**
     * @param ItemsRepositoryInterface $itemsRepository
     */
    public function setItemsRepository(ItemsRepositoryInterface $itemsRepository): void
    {
        $this->itemsRepository = $itemsRepository;
    }

    /**
     * @return ItemsInputFieldsRepositoryInterface
     * @throws DiException
     */
    public function getItemsInputFieldsRepository(): ItemsInputFieldsRepositoryInterface
    {
        if (null === $this->itemsInputFieldsRepository) {
            throw new DiException('ItemsInputFieldsRepository');
        }

        return $this->itemsInputFieldsRepository;
    }

    /**
     * @param ItemsInputFieldsRepositoryInterface $itemsInputFieldsRepository
     */
    public function setItemsInputFieldsRepository(ItemsInputFieldsRepositoryInterface $itemsInputFieldsRepository): void
    {
        $this->itemsInputFieldsRepository = $itemsInputFieldsRepository;
    }

    /**
     * @return ItemsInputFieldsLocalizationRepositoryInterface
     * @throws DiException
     */
    public function getItemsInputFieldsLocalizationRepository(): ItemsInputFieldsLocalizationRepositoryInterface
    {
        if (null === $this->itemsInputFieldsLocalizationRepository) {
            throw new DiException('ItemsInputFieldsLocalizationRepository');
        }

        return $this->itemsInputFieldsLocalizationRepository;
    }

    /**
     * @param ItemsInputFieldsLocalizationRepositoryInterface $itemsInputFieldsLocalizationRepository
     */
    public function setItemsInputFieldsLocalizationRepository(ItemsInputFieldsLocalizationRepositoryInterface $itemsInputFieldsLocalizationRepository): void
    {
        $this->itemsInputFieldsLocalizationRepository = $itemsInputFieldsLocalizationRepository;
    }

    /**
     * @return ItemsLocalizationRepositoryInterface
     * @throws DiException
     */
    public function getItemsLocalizationRepository(): ItemsLocalizationRepositoryInterface
    {
        if (null === $this->itemsLocalizationRepository) {
            throw new DiException('ItemsLocalizationRepository');
        }

        return $this->itemsLocalizationRepository;
    }

    /**
     * @param ItemsLocalizationRepositoryInterface $itemsLocalizationRepository
     */
    public function setItemsLocalizationRepository(ItemsLocalizationRepositoryInterface $itemsLocalizationRepository): void
    {
        $this->itemsLocalizationRepository = $itemsLocalizationRepository;
    }

    /**
     * @return ItemTypesRepositoryInterface
     * @throws DiException
     */
    public function getItemTypesRepository(): ItemTypesRepositoryInterface
    {
        if (null === $this->itemTypesRepository) {
            throw new DiException('ItemTypesRepository');
        }

        return $this->itemTypesRepository;
    }

    /**
     * @param ItemTypesRepositoryInterface $itemTypesRepository
     */
    public function setItemTypesRepository(ItemTypesRepositoryInterface $itemTypesRepository): void
    {
        $this->itemTypesRepository = $itemTypesRepository;
    }

    /**
     * @return ServicesLocalizationRepositoryInterface
     * @throws DiException
     */
    public function getServicesLocalizationRepository(): ServicesLocalizationRepositoryInterface
    {
        if (null === $this->servicesLocalizationRepository) {
            throw new DiException('ServicesLocalizationRepository');
        }

        return $this->servicesLocalizationRepository;
    }

    /**
     * @param ServicesLocalizationRepositoryInterface $servicesLocalizationRepository
     */
    public function setServicesLocalizationRepository(ServicesLocalizationRepositoryInterface $servicesLocalizationRepository): void
    {
        $this->servicesLocalizationRepository = $servicesLocalizationRepository;
    }

    /**
     * @return OperatorsLocalizationRepositoryInterface
     * @throws DiException
     */
    public function getOperatorsLocalizationRepository(): OperatorsLocalizationRepositoryInterface
    {
        if (null === $this->operatorsLocalizationRepository) {
            throw new DiException('OperatorsLocalizationRepository');
        }

        return $this->operatorsLocalizationRepository;
    }

    /**
     * @param OperatorsLocalizationRepositoryInterface $operatorsLocalizationRepository
     */
    public function setOperatorsLocalizationRepository(OperatorsLocalizationRepositoryInterface $operatorsLocalizationRepository): void
    {
        $this->operatorsLocalizationRepository = $operatorsLocalizationRepository;
    }

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
     * @return MccCodesRepositoryInterface
     * @throws DiException
     */
    public function getMccCodesRepository(): MccCodesRepositoryInterface
    {
        if (null === $this->mccCodesRepository) {
            throw new DiException('MccCodesRepository');
        }
        return $this->mccCodesRepository;
    }

    /**
     * @param MccCodesRepositoryInterface $mccCodesRepository
     */
    public function setMccCodesRepository(MccCodesRepositoryInterface $mccCodesRepository): void
    {
        $this->mccCodesRepository = $mccCodesRepository;
    }
}
