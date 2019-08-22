<?php

declare(strict_types=1);

namespace System\Facade\Talk;

use System\Component\Button\ButtonComponentInterface;
use System\Component\MessageProcessing\MessageProcessingComponentInterface;
use System\Exception\DiException;
use System\Repository\Chats\ChatsRepositoryInterface;
use System\Repository\ItemsLocalization\ItemsLocalizationRepositoryInterface;
use System\Repository\ItemsTags\ItemsTagsRepositoryInterface;
use System\Repository\StagesMessages\StagesMessagesRepositoryInterface;
use System\Repository\Talk\TalkRepositoryInterface;


/**
 * Trait TalkFacadeDependenciesTrait
 * @package System\Facade\Talk
 */
trait TalkFacadeDependenciesTrait
{
    /**
     * @var TalkRepositoryInterface
     */
    private $talkRepository;
    
    /**
     * @var ChatsRepositoryInterface
     */
    private $chatsRepository;

    /**
     * @var StagesMessagesRepositoryInterface
     */
    private $stagesMessagesRepository;

    /**
     * @var MessageProcessingComponentInterface
     */
    private $messageProcessingComponent;

    /**
     * @var ItemsTagsRepositoryInterface
     */
    private $itemsTagsRepository;

    /**
     * @var ItemsLocalizationRepositoryInterface
     */
    private $itemsLocalizationRepository;


    /**
     * @var ButtonComponentInterface
     */
    private $buttonComponent;

    /**
     * @return TalkRepositoryInterface
     * 
     * @throws DiException
     */
    public function getTalkRepository(): TalkRepositoryInterface
    {
        if ($this->talkRepository === null) {
            throw new DiException('TalkRepository');
        }
        return $this->talkRepository;
    }

    /**
     * @param TalkRepositoryInterface $talkRepository
     */
    public function setTalkRepository(TalkRepositoryInterface $talkRepository): void
    {
        $this->talkRepository = $talkRepository;
    }

    /**
     * @return ChatsRepositoryInterface
     * 
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
     * @return ItemsTagsRepositoryInterface
     * @throws DiException
     */
    public function getItemsTagsRepository(): ItemsTagsRepositoryInterface
    {
        if ($this->itemsTagsRepository === null) {
            throw new DiException('ItemsTagsRepository');
        }

        return $this->itemsTagsRepository;
    }

    /**
     * @param ItemsTagsRepositoryInterface $itemsTagsRepository
     */
    public function setItemsTagsRepository(ItemsTagsRepositoryInterface $itemsTagsRepository): void
    {
        $this->itemsTagsRepository = $itemsTagsRepository;
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