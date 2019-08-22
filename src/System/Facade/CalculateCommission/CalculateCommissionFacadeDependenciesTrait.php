<?php

declare(strict_types=1);

namespace System\Facade\CalculateCommission;

use System\Component\MessageProcessing\MessageProcessingComponentInterface;
use System\Exception\DiException;
use System\Repository\Chats\ChatsRepositoryInterface;
use System\Repository\Cheques\ChequesRepositoryInterface;
use System\Repository\ChequesCommissions\ChequesCommissionsRepositoryInterface;
use System\Repository\Commissions\CommissionsRepositoryInterface;
use System\Repository\StagesMessages\StagesMessagesRepositoryInterface;

trait CalculateCommissionFacadeDependenciesTrait
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
     * @var CommissionsRepositoryInterface
     */
    private $commissionsRepository;

    /**
     * @var ChequesCommissionsRepositoryInterface
     */
    private $chequesCommissionsRepository;

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
        if (null === $this->chatsRepository) {
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
        if (null === $this->stagesMessagesRepository) {
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
        if (null === $this->chequesRepository) {
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
     * @return CommissionsRepositoryInterface
     * @throws DiException
     */
    public function getCommissionsRepository(): CommissionsRepositoryInterface
    {
        if (null === $this->commissionsRepository) {
            throw new DiException('CommissionsRepository');
        }
        return $this->commissionsRepository;
    }

    /**
     * @param CommissionsRepositoryInterface $commissionsRepository
     */
    public function setCommissionsRepository(CommissionsRepositoryInterface $commissionsRepository): void
    {
        $this->commissionsRepository = $commissionsRepository;
    }

    /**
     * @return ChequesCommissionsRepositoryInterface
     * @throws DiException
     */
    public function getChequesCommissionsRepository(): ChequesCommissionsRepositoryInterface
    {
        if (null === $this->chequesCommissionsRepository) {
            throw new DiException('ChequesCommissionsRepository');
        }
        return $this->chequesCommissionsRepository;
    }

    /**
     * @param ChequesCommissionsRepositoryInterface $chequesCommissionsRepository
     */
    public function setChequesCommissionsRepository(ChequesCommissionsRepositoryInterface $chequesCommissionsRepository): void
    {
        $this->chequesCommissionsRepository = $chequesCommissionsRepository;
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
