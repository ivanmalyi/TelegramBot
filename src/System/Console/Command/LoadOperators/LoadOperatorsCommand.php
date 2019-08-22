<?php

declare(strict_types=1);

namespace System\Console\Command\LoadOperators;

use System\Console\AbstractCommand;
use System\Entity\Component\Billing\Response\LoadOperatorsResponse;
use System\Entity\Component\FlashNoticeTransport;
use System\Entity\InternalProtocol\ResponseCode;
use System\Entity\Repository\Section;
use System\Kernel\Protocol\AnswerBundle;
use System\Kernel\Protocol\CommandLinePacket;

/**
 * Class LoadOperatorsCommand
 * @package System\Console\Command
 */
class LoadOperatorsCommand extends AbstractCommand
{
    use LoadOperatorsCommandDependenciesTrait;

    /**
     * @var array
     */
    private $allowedItemTypes = [2, 3, 12, 14];

    /**
     * @param CommandLinePacket $packet
     * @return AnswerBundle
     * @throws \ReflectionException
     * @throws \System\Exception\DiException
     */
    public function handle(CommandLinePacket $packet): AnswerBundle
    {
       $loadOperator = $this->getBillingComponent()->loadOperators();

       $result = $loadOperator->getResult();
       if ($result == ResponseCode::SUCCESS_ACTION) {
            $this->saveOperatorsResponse($loadOperator);
            $this->offAllowedTypes();
            
           $answerBundle = new AnswerBundle(['Result' => ResponseCode::SUCCESS_ACTION]);
       } else {
           $this->getFlashNotice()->sendMessage(
               strtolower((new \ReflectionClass($this))->getShortName()).
               "\nOperators not loaded\n result: {$result}",
               FlashNoticeTransport::TELEGRAM
           );

           $answerBundle = new AnswerBundle(['Result' => ResponseCode::UNKNOWN_ERROR]);
       }

        return $answerBundle;
    }

    /**
     * @param LoadOperatorsResponse $loadOperatorsResponse
     * @throws \System\Exception\DiException
     */
    private function saveOperatorsResponse(LoadOperatorsResponse $loadOperatorsResponse): void
    {
        $this->saveSections($loadOperatorsResponse->getSections());
        $this->saveOperators($loadOperatorsResponse);
        $this->saveServices($loadOperatorsResponse);
        $this->saveItems($loadOperatorsResponse);
    }

    /**
     * @param Section[] $sections
     * @throws \System\Exception\DiException
     */
    private function saveSections(array $sections): void
    {
        $this->getSectionsRepository()->clearSections();
        $this->getSectionsRepository()->saveSections($sections);
    }

    /**
     * @param LoadOperatorsResponse $loadOperatorsResponse
     * @throws \System\Exception\DiException
     */
    private function saveOperators(LoadOperatorsResponse $loadOperatorsResponse): void
    {
        $this->getOperatorsRepository()->clearOperators();
        $this->getOperatorsRepository()->saveOperators($loadOperatorsResponse->getOperators());

        $this->getOperatorsLocalizationRepository()->clearOperatorsLocalization();
        $this->getOperatorsLocalizationRepository()
            ->saveOperatorsLocalization($loadOperatorsResponse->getOperatorsLocalization());
    }

    /**
     * @param LoadOperatorsResponse $loadOperatorsResponse
     * @throws \System\Exception\DiException
     */
    private function saveServices(LoadOperatorsResponse $loadOperatorsResponse): void
    {
        $this->getServicesRepository()->clearServices();
        $this->getServicesRepository()->saveServices($loadOperatorsResponse->getServices());

        $this->getServicesLocalizationRepository()->clearServicesLocalization();
        $this->getServicesLocalizationRepository()->saveServicesLocalization($loadOperatorsResponse->getServicesLocalization());
    }

    /**
     * @param LoadOperatorsResponse $loadOperatorsResponse
     * @throws \System\Exception\DiException
     */
    private function saveItems(LoadOperatorsResponse $loadOperatorsResponse): void
    {
        $this->getItemsRepository()->clearItems();
        $this->getItemsRepository()->saveItems($loadOperatorsResponse->getItems());

        $this->getItemsLocalizationRepository()->clearItemsLocalization();
        $this->getItemsLocalizationRepository()->saveItemsLocalization($loadOperatorsResponse->getItemLocalization());

        $this->getItemsInputFieldsLocalizationRepository()->clearItemsInputFieldsLocalization();
        $this->getItemsInputFieldsRepository()->clearItemsInputFields();

        $this->getItemTypesRepository()->clearItemTypes();
        $this->getItemTypesRepository()->saveItemTypes($loadOperatorsResponse->getItemTypes());

        foreach ($loadOperatorsResponse->getInputFields() as $inputField) {
            $itemsInputId = $this->getItemsInputFieldsRepository()->saveItemsInputFields($inputField);
            $this->getItemsInputFieldsLocalizationRepository()
                ->saveItemsInputFieldsLocalization($inputField->getFieldNames(), $itemsInputId);
        }
    }

    /**
     * @throws \System\Exception\DiException
     */
    private function offAllowedTypes(): void
    {
        $this->offItems();
        $this->offServices();
        $this->offOperators();
    }

    /**
     * @throws \System\Exception\DiException
     */
    private function offItems(): void
    {
        $items = $this->getItemsRepository()->findAllItems();
        $supportedMcc = $this->getMccCodesRepository()->findAllSupportedIds();

        foreach ($items as $item) {
            if (!in_array($item->getMcc(), $supportedMcc)) {
                $this->getItemsRepository()->updateStatus($item->getId(), 0);
                continue;
            }

            $itemTypes = $this->getItemTypesRepository()->findTypesForItem($item->getId());
            $forbiddenTypes = array_diff($itemTypes, $this->allowedItemTypes);
            if (!empty($forbiddenTypes and $item->getId() !== 2931)) {
                $this->getItemsRepository()->updateStatus($item->getId(), 0);
            }
        }
    }

    /**
     * @throws \System\Exception\DiException
     */
    private function offServices(): void
    {
        $services = $this->getServicesRepository()->findAllByItemOn();

        $servicesId = [];
        foreach ($services as $service) {
            $servicesId[] = $service->getId();
        }
        $this->getServicesRepository()->updateStatuses($servicesId, 0);
    }

    /**
     * @throws \System\Exception\DiException
     */
    private function offOperators(): void
    {
        $operators = $this->getOperatorsRepository()->findAllByServiceOn();

        $operatorsId = [];
        foreach ($operators as $operator) {
            $operatorsId[] = $operator->getId();
        }

        $this->getOperatorsRepository()->updateStatuses($operatorsId, 0);
    }
}