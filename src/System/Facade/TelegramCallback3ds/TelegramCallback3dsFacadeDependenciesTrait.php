<?php

declare(strict_types=1);

namespace System\Facade\TelegramCallback3ds;

use System\Component\MessageProcessing\MessageProcessingComponentInterface;
use System\Exception\DiException;
use System\Repository\Chats\ChatsRepositoryInterface;
use System\Repository\Cheques\ChequesRepositoryInterface;
use System\Repository\ChequesCallbackUrls\ChequesCallbackUrlsRepositoryInterface;
use System\Repository\Payments\PaymentsRepositoryInterface;
use System\Repository\StagesMessages\StagesMessagesRepositoryInterface;

/**
 * Trait TelegramCallback3dsFacadeDependenciesTrait
 * @package System\Facade\TelegramCallback3ds
 */
trait TelegramCallback3dsFacadeDependenciesTrait
{
    /**
     * @var ChequesRepositoryInterface
     */
    private $chequesRepository;

    /**
     * @var ChequesCallbackUrlsRepositoryInterface
     */
    private $chequesCallbackUrlsRepository;

    /**
     * @var ChatsRepositoryInterface
     */
    private $chatsRepository;

    /**
     * @var StagesMessagesRepositoryInterface
     */
    private $stagesMessagesRepository;

    /**
     * @var PaymentsRepositoryInterface
     */
    private $paymentsRepository;

    /**
     * @var MessageProcessingComponentInterface
     */
    private $messageProcessingComponent;

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
     * @return PaymentsRepositoryInterface
     * @throws DiException
     */
    public function getPaymentsRepository(): PaymentsRepositoryInterface
    {
        if ($this->paymentsRepository === null) {
            throw new DiException('PaymentsRepository');
        }
        return $this->paymentsRepository;
    }

    /**
     * @param PaymentsRepositoryInterface $paymentsRepository
     */
    public function setPaymentsRepository(PaymentsRepositoryInterface $paymentsRepository): void
    {
        $this->paymentsRepository = $paymentsRepository;
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
