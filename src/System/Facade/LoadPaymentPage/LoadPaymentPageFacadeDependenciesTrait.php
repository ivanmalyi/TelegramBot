<?php

declare(strict_types=1);

namespace System\Facade\LoadPaymentPage;

use System\Component\Billing\BillingComponentInterface;
use System\Component\Button\ButtonComponentInterface;
use System\Component\MessageProcessing\MessageProcessingComponentInterface;
use System\Exception\DiException;
use System\Repository\CallbackUrls\CallbackUrlsRepositoryInterface;
use System\Repository\Chats\ChatsRepositoryInterface;
use System\Repository\Cheques\ChequesRepositoryInterface;
use System\Repository\ChequesCallbackUrls\ChequesCallbackUrlsRepositoryInterface;
use System\Repository\Items\ItemsRepositoryInterface;
use System\Repository\StagesMessages\StagesMessagesRepositoryInterface;

/**
 * Trait LoadPaymentPageFacadeDependenciesTrait
 * @package System\Facade\LoadPaymentPage
 */
trait LoadPaymentPageFacadeDependenciesTrait
{
    /**
     * @var ChatsRepositoryInterface
     */
    private $chatsRepository;

    /**
     * @var StagesMessagesRepositoryInterface
     */
    private $stagesMessagesRepository;

    /**
     * @var BillingComponentInterface
     */
    private $billingComponent;

    /**
     * @var ChequesRepositoryInterface
     */
    private $chequesRepository;

    /**
     * @var CallbackUrlsRepositoryInterface
     */
    private $callbackUrlsRepository;

    /**
     * @var ItemsRepositoryInterface
     */
    private $itemsRepository;

    /**
     * @var ChequesCallbackUrlsRepositoryInterface
     */
    private $chequesCallbackUrlsRepository;

    /**
     * @var MessageProcessingComponentInterface
     */
    private $messageProcessingComponent;

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
     * @return BillingComponentInterface
     *
     * @throws DiException
     */
    public function getBillingComponent(): BillingComponentInterface
    {
        if ($this->billingComponent === null) {
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
     * @return CallbackUrlsRepositoryInterface
     *
     * @throws DiException
     */
    public function getCallbackUrlsRepository(): CallbackUrlsRepositoryInterface
    {
        if ($this->callbackUrlsRepository === null) {
            throw new DiException('CallbackUrlsRepository');
        }
        return $this->callbackUrlsRepository;
    }

    /**
     * @param CallbackUrlsRepositoryInterface $callbackUrlsRepository
     */
    public function setCallbackUrlsRepository(CallbackUrlsRepositoryInterface $callbackUrlsRepository): void
    {
        $this->callbackUrlsRepository = $callbackUrlsRepository;
    }

    /**
     * @return ChequesCallbackUrlsRepositoryInterface
     *
     * @throws DiException
     */
    public function getChequesCallbackUrlsRepository(): ChequesCallbackUrlsRepositoryInterface
    {
        if ($this->chequesCallbackUrlsRepository === null) {
            throw new DiException('ChequesCallbackUrlsRepository');
        }
        return $this->chequesCallbackUrlsRepository;
    }

    /**
     * @param ChequesCallbackUrlsRepositoryInterface $chequesCallbackUrlsRepository
     */
    public function setChequesCallbackUrlsRepository(ChequesCallbackUrlsRepositoryInterface $chequesCallbackUrlsRepository): void
    {
        $this->chequesCallbackUrlsRepository = $chequesCallbackUrlsRepository;
    }

    /**
     * @return ItemsRepositoryInterface
     * @throws DiException
     */
    public function getItemsRepository(): ItemsRepositoryInterface
    {
        if ($this->itemsRepository === null) {
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
