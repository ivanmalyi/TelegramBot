<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;

use System\Entity\Provider\InputField;
use System\Entity\Repository\Item;
use System\Entity\Repository\ItemLocalization;
use System\Entity\Repository\ItemType;
use System\Entity\Repository\Operator;
use System\Entity\Repository\OperatorLocalization;
use System\Entity\Repository\Section;
use System\Entity\Repository\Service;
use System\Entity\Repository\ServiceLocalization;

/**
 * Class LoadOperatorsResponse
 * @package System\Entity\Component\Billing\Response
 */
class LoadOperatorsResponse extends Response
{
    /**
     * @var Section[]
     */
    private $sections;

    /**
     * @var Operator[]
     */
    private $operators;

    /**
     * @var Service[]
     */
    private $services;

    /**
     * @var Item[]
     */
    private $items;

    /**
     * @var InputField[]
     */
    private $inputFields;

    /**
     * @var ItemLocalization[]
     */
    private $itemLocalization;

    /**
     * @var ItemType[]
     */
    private $itemTypes;

    /**
     * @var ServiceLocalization[]
     */
    private $servicesLocalization;

    /**
     * @var OperatorLocalization[]
     */
    private $operatorsLocalization;

    /**
     * LoadOperatorsResponse constructor.
     * @param int $result
     * @param string $time
     */
    public function __construct(int $result, string $time)
    {
        parent::__construct($result, $time);
    }

    /**
     * @return Section[]
     */
    public function getSections(): array
    {
        return $this->sections;
    }

    /**
     * @param Section[] $sections
     */
    public function setSections(array $sections): void
    {
        $this->sections = $sections;
    }

    /**
     * @return Operator[]
     */
    public function getOperators(): array
    {
        return $this->operators;
    }

    /**
     * @param Operator[] $operators
     */
    public function setOperators(array $operators): void
    {
        $this->operators = $operators;
    }

    /**
     * @return Service[]
     */
    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * @param Service[] $services
     */
    public function setServices(array $services): void
    {
        $this->services = $services;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param Item[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @return InputField[]
     */
    public function getInputFields(): array
    {
        return $this->inputFields;
    }

    /**
     * @param InputField[] $inputFields
     */
    public function setInputFields(array $inputFields): void
    {
        $this->inputFields = $inputFields;
    }

    /**
     * @return ItemLocalization[]
     */
    public function getItemLocalization(): array
    {
        return $this->itemLocalization;
    }

    /**
     * @param ItemLocalization[] $itemLocalization
     */
    public function setItemLocalization(array $itemLocalization): void
    {
        $this->itemLocalization = $itemLocalization;
    }

    /**
     * @return ItemType[]
     */
    public function getItemTypes(): array
    {
        return $this->itemTypes;
    }

    /**
     * @param ItemType[] $itemTypes
     */
    public function setItemTypes(array $itemTypes): void
    {
        $this->itemTypes = $itemTypes;
    }

    /**
     * @return ServiceLocalization[]
     */
    public function getServicesLocalization(): array
    {
        return $this->servicesLocalization;
    }

    /**
     * @param ServiceLocalization[] $servicesLocalization
     */
    public function setServicesLocalization(array $servicesLocalization): void
    {
        $this->servicesLocalization = $servicesLocalization;
    }

    /**
     * @return OperatorLocalization[]
     */
    public function getOperatorsLocalization(): array
    {
        return $this->operatorsLocalization;
    }

    /**
     * @param OperatorLocalization[] $operatorsLocalization
     */
    public function setOperatorsLocalization(array $operatorsLocalization): void
    {
        $this->operatorsLocalization = $operatorsLocalization;
    }
}