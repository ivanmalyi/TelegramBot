<?php

declare(strict_types=1);

namespace System\Facade\LoadItemInputFields;

use System\Component\Button\ButtonComponentInterface;
use System\Component\MessageProcessing\MessageProcessingComponentInterface;
use System\Exception\DiException;
use System\Repository\Chats\ChatsRepositoryInterface;
use System\Repository\Cheques\ChequesRepositoryInterface;
use System\Repository\ItemsInputFields\ItemsInputFieldsRepositoryInterface;
use System\Repository\ItemsInputFieldsLocalization\ItemsInputFieldsLocalizationRepositoryInterface;
use System\Repository\StagesMessages\StagesMessagesRepositoryInterface;

/**
 * Class LoadItemInputFieldsFacadeDependenciesTrait
 * @package System\Facade\LoadItemInputFields
 */
trait LoadItemInputFieldsFacadeDependenciesTrait
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
     * @var ItemsInputFieldsRepositoryInterface
     */
    private $itemsInputFieldsRepository;

    /**
     * @var ItemsInputFieldsLocalizationRepositoryInterface
     */
    private $itemsInputFieldsLocalizationRepository;

    /**
     * @var ChequesRepositoryInterface
     */
    private $chequesRepository;

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
     *
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
     * @return ItemsInputFieldsRepositoryInterface
     *
     * @throws DiException
     */
    public function getItemsInputFieldsRepository(): ItemsInputFieldsRepositoryInterface
    {
        if ($this->itemsInputFieldsRepository === null) {
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
     *
     * @throws DiException
     */
    public function getItemsInputFieldsLocalizationRepository(): ItemsInputFieldsLocalizationRepositoryInterface
    {
        if ($this->itemsInputFieldsLocalizationRepository === null) {
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
