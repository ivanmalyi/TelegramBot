<?php

declare(strict_types=1);

namespace System\Facade\Start;

use System\Component\Button\ButtonComponentInterface;
use System\Component\MessageProcessing\MessageProcessingComponentInterface;
use System\Exception\DiException;
use System\Repository\Chats\ChatsRepositoryInterface;
use System\Repository\StagesMessages\StagesMessagesRepositoryInterface;
use System\Repository\UserAds\UserAdsRepositoryInterface;
use System\Repository\Users\UsersRepositoryInterface;

/**
 * Trait VerifyFacadeDependenciesTrait
 * @package System\Facade\Verify
 */
trait StartFacadeDependenciesTrait
{
    /**
     * @var UsersRepositoryInterface
     */
    private $usersRepository;

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
     * @var ButtonComponentInterface
     */
    private $buttonComponent;

    /**
     * @var UserAdsRepositoryInterface
     */
    private $userAdsRepository;

    /**
     * @return UsersRepositoryInterface
     * @throws DiException
     */
    public function getUsersRepository(): UsersRepositoryInterface
    {
        if ($this->usersRepository === null) {
            throw new DiException('UsersRepository');
        }
        return $this->usersRepository;
    }

    /**
     * @param UsersRepositoryInterface $usersRepository
     */
    public function setUsersRepository(UsersRepositoryInterface $usersRepository): void
    {
        $this->usersRepository = $usersRepository;
    }

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

    /**
     * @return UserAdsRepositoryInterface
     * @throws DiException
     */
    public function getUserAdsRepository(): UserAdsRepositoryInterface
    {
        if ($this->userAdsRepository === null) {
            throw new DiException('UserAdsRepository');
        }
        return $this->userAdsRepository;
    }

    /**
     * @param UserAdsRepositoryInterface $userAdsRepository
     */
    public function setUserAdsRepository(UserAdsRepositoryInterface $userAdsRepository): void
    {
        $this->userAdsRepository = $userAdsRepository;
    }
}
