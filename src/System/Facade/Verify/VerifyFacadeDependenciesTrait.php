<?php

declare(strict_types=1);

namespace System\Facade\Verify;


use System\Component\Billing\BillingComponentInterface;
use System\Component\Button\ButtonComponentInterface;
use System\Component\MessageProcessing\MessageProcessingComponentInterface;
use System\Exception\DiException;
use System\Repository\AcquiringCommission\AcquiringCommissionRepositoryInterface;
use System\Repository\Chats\ChatsRepositoryInterface;
use System\Repository\ChequePrint\ChequePrintRepositoryInterface;
use System\Repository\Cheques\ChequesRepositoryInterface;
use System\Repository\Display\DisplayRepositoryInterface;
use System\Repository\ItemTypes\ItemTypesRepositoryInterface;
use System\Repository\StagesMessages\StagesMessagesRepositoryInterface;

/**
 * Trait VerifyFacadeDependenciesTrait
 * @package System\Facade\Verify
 */
trait VerifyFacadeDependenciesTrait
{
    /**
     * @var ChatsRepositoryInterface
     */
    private $chatsRepository;

    /**
     * @var ChequesRepositoryInterface
     */
    private $chequesRepository;

    /**
     * @var BillingComponentInterface
     */
    private $billingComponent;

    /**
     * @var StagesMessagesRepositoryInterface
     */
    private $stagesMessagesRepository;

    /**
     * @var DisplayRepositoryInterface
     */
    private $displayRepository;

    /**
     * @var ChequePrintRepositoryInterface
     */
    private $chequePrintRepository;

    /**
     * @var AcquiringCommissionRepositoryInterface
     */
    private $acquiringCommissionRepository;

    /**
     * @var MessageProcessingComponentInterface
     */
    private $messageProcessingComponent;

    /**
     * @var ItemTypesRepositoryInterface
     */
    private $itemTypesRepository;

    /**
     * @var ButtonComponentInterface
     */
    private $buttonComponent;

    /**
     * @return ChatsRepositoryInterface
     * @throws DiException
     */
    public function getChatsRepository(): ChatsRepositoryInterface
    {
        if ($this->chatsRepository === null) {
            throw new DiException('ChatsRepository');
        }
        return $this->chatsRepository;
    }

    /**
     * @param ChatsRepositoryInterface $chatsRepository
     */
    public function setChatsRepository(ChatsRepositoryInterface $chatsRepository): void
    {
        $this->chatsRepository = $chatsRepository;
    }

    /**
     * @return ChequesRepositoryInterface
     *
     * @throws DiException
     */
    public function getChequesRepository(): ChequesRepositoryInterface
    {
        if ($this->chequesRepository === null) {
            throw new DiException('ChequesRepository');
        }
        return $this->chequesRepository;
    }

    /**
     * @param ChequesRepositoryInterface $chequesRepository
     */
    public function setChequesRepository(ChequesRepositoryInterface $chequesRepository): void
    {
        $this->chequesRepository = $chequesRepository;
    }

    /**
     * @return BillingComponentInterface
     * @throws DiException
     */
    public function getBillingComponent(): BillingComponentInterface
    {
        if (null === $this->billingComponent) {
            throw new DiException('BillingComponent');
        }

        return $this->billingComponent;
    }

    /**
     * @param BillingComponentInterface $billingComponent
     */
    public function setBillingComponent(BillingComponentInterface $billingComponent): void
    {
        $this->billingComponent = $billingComponent;
    }

    /**
     * @return StagesMessagesRepositoryInterface
     * @throws DiException
     */
    public function getStagesMessagesRepository(): StagesMessagesRepositoryInterface
    {
        if ($this->stagesMessagesRepository === null) {
            throw new DiException('StagesMessagesRepository');
        }
        return $this->stagesMessagesRepository;
    }

    /**
     * @param StagesMessagesRepositoryInterface $stagesMessagesRepository
     */
    public function setStagesMessagesRepository(StagesMessagesRepositoryInterface $stagesMessagesRepository): void
    {
        $this->stagesMessagesRepository = $stagesMessagesRepository;
    }

    /**
     * @return DisplayRepositoryInterface
     * @throws DiException
     */
    public function getDisplayRepository(): DisplayRepositoryInterface
    {
        if ($this->displayRepository === null) {
            throw new DiException('DisplayRepository');
        }
        return $this->displayRepository;
    }

    /**
     * @param DisplayRepositoryInterface $displayRepository
     */
    public function setDisplayRepository(DisplayRepositoryInterface $displayRepository): void
    {
        $this->displayRepository = $displayRepository;
    }

    /**
     * @return ChequePrintRepositoryInterface
     * @throws DiException
     */
    public function getChequePrintRepository(): ChequePrintRepositoryInterface
    {
        if ($this->chequePrintRepository === null) {
            throw new DiException('ChequePrintRepository');
        }
        return $this->chequePrintRepository;
    }

    /**
     * @param ChequePrintRepositoryInterface $chequePrintRepository
     */
    public function setChequePrintRepository(ChequePrintRepositoryInterface $chequePrintRepository): void
    {
        $this->chequePrintRepository = $chequePrintRepository;
    }

    /**
     * @return AcquiringCommissionRepositoryInterface
     * @throws DiException
     */
    public function getAcquiringCommissionRepository(): AcquiringCommissionRepositoryInterface
    {
        if ($this->acquiringCommissionRepository === null) {
            throw new DiException('AcquiringCommissionRepository');
        }
        return $this->acquiringCommissionRepository;
    }

    /**
     * @param AcquiringCommissionRepositoryInterface $acquiringCommissionRepository
     */
    public function setAcquiringCommissionRepository(AcquiringCommissionRepositoryInterface $acquiringCommissionRepository): void
    {
        $this->acquiringCommissionRepository = $acquiringCommissionRepository;
    }

    /**
     * @return MessageProcessingComponentInterface
     * @throws DiException
     */
    public function getMessageProcessingComponent(): MessageProcessingComponentInterface
    {
        if (null === $this->messageProcessingComponent) {
            throw new DiException('MessageProcessingComponent');
        }
        return $this->messageProcessingComponent;
    }

    /**
     * @param MessageProcessingComponentInterface $messageProcessingComponent
     */
    public function setMessageProcessingComponent(MessageProcessingComponentInterface $messageProcessingComponent): void
    {
        $this->messageProcessingComponent = $messageProcessingComponent;
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
     * @return ButtonComponentInterface
     *
     * @throws DiException
     */
    public function getButtonComponent(): ButtonComponentInterface
    {
        if (null === $this->buttonComponent) {
            throw new DiException('ButtonComponent');
        }
        return $this->buttonComponent;
    }

    /**
     * @param ButtonComponentInterface $buttonComponent
     */
    public function setButtonComponent(ButtonComponentInterface $buttonComponent): void
    {
        $this->buttonComponent = $buttonComponent;
    }
}
