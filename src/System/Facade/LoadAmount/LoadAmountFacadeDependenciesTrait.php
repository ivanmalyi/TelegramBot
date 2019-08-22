<?php

declare(strict_types=1);

namespace System\Facade\LoadAmount;

use System\Component\MessageProcessing\MessageProcessingComponentInterface;
use System\Exception\DiException;
use System\Repository\Chats\ChatsRepositoryInterface;
use System\Repository\Cheques\ChequesRepositoryInterface;
use System\Repository\Display\DisplayRepositoryInterface;
use System\Repository\Items\ItemsRepositoryInterface;
use System\Repository\StagesMessages\StagesMessagesRepositoryInterface;

/**
 * Trait LoadAmountFacadeDependenciesTrait
 * @package System\Facade\LoadAmount
 */
trait LoadAmountFacadeDependenciesTrait
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
     * @var ChequesRepositoryInterface
     */
    private $chequesRepository;

    /**
     * @var ItemsRepositoryInterface
     */
    private $itemsRepository;

    /**
     * @var DisplayRepositoryInterface
     */
    private $displayRepository;

    /**
     * @var MessageProcessingComponentInterface
     */
    private $messageProcessingComponent;

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
     * @return ItemsRepositoryInterface
     *
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
}
