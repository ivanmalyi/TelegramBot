<?php

declare(strict_types=1);

namespace System\Facade\LoadItems;


use System\Component\Button\ButtonComponentInterface;
use System\Component\MessageProcessing\MessageProcessingComponentInterface;
use System\Exception\DiException;
use System\Repository\Chats\ChatsRepositoryInterface;
use System\Repository\Items\ItemsRepositoryInterface;
use System\Repository\StagesMessages\StagesMessagesRepositoryInterface;

trait LoadItemsFacadeDependenciesTrait
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
     * @var ItemsRepositoryInterface
     */
    private $itemsRepository;

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