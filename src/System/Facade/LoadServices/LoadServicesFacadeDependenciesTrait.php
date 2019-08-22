<?php

declare(strict_types=1);

namespace System\Facade\LoadServices;

use System\Component\Button\ButtonComponentInterface;
use System\Component\MessageProcessing\MessageProcessingComponentInterface;
use System\Exception\DiException;
use System\Repository\Chats\ChatsRepositoryInterface;
use System\Repository\Services\ServicesRepositoryInterface;
use System\Repository\ServicesLocalization\ServicesLocalizationRepositoryInterface;
use System\Repository\StagesMessages\StagesMessagesRepositoryInterface;

/**
 * Trait GetServicesFacadeDependenciesTrait
 * @package System\Facade\GetServices
 */
trait LoadServicesFacadeDependenciesTrait
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
     * @var ServicesRepositoryInterface
     */
    private $servicesRepository;

    /**
     * @var ServicesLocalizationRepositoryInterface
     */
    private $servicesLocalizationRepository;

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
     * @return ServicesRepositoryInterface
     *
     * @throws DiException
     */
    public function getServicesRepository(): ServicesRepositoryInterface
    {
        if ($this->servicesRepository === null) {
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
     * @return ServicesLocalizationRepositoryInterface
     *
     * @throws DiException
     */
    public function getServicesLocalizationRepository(): ServicesLocalizationRepositoryInterface
    {
        if ($this->servicesLocalizationRepository === null) {
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
