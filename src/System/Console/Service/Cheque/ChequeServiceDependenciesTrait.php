<?php

declare(strict_types=1);

namespace System\Console\Service\Cheque;

use System\Component\CreateCheque\CreateChequeComponentInterface;
use System\Component\MessageProcessing\MessageProcessingComponentInterface;
use System\Component\PayBot\PayBotInterface;
use System\Exception\DiException;
use System\Repository\Chats\ChatsRepositoryInterface;
use System\Repository\ChequesText\ChequesTextRepositoryInterface;
use System\Repository\Payments\PaymentsRepositoryInterface;
use System\Repository\StagesMessages\StagesMessagesRepositoryInterface;

/**
 * Trait ChequeServiceDependenciesTrait
 * @package System\Console\Service\Cheque
 */
trait ChequeServiceDependenciesTrait
{
    /**
     * @var PaymentsRepositoryInterface
     */
    private $paymentsRepository;

    /**
     * @var ChatsRepositoryInterface
     */
    private $chatsRepository;

    /**
     * @var PayBotInterface
     */
    private $payBot;

    /**
     * @var ChequesTextRepositoryInterface
     */
    private $chequesTextRepository;

    /**
     * @var CreateChequeComponentInterface
     */
    private $createChequeComponent;

    /**
     * @var MessageProcessingComponentInterface
     */
    private $messageProcessingComponent;

    /**
     * @return PaymentsRepositoryInterface
     * @throws DiException
     */
    public function getPaymentsRepository(): PaymentsRepositoryInterface
    {
        if (null === $this->paymentsRepository) {
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
     * @return PayBotInterface
     * @throws DiException
     */
    public function getPayBot(): PayBotInterface
    {
        if (null === $this->payBot) {
            throw new DiException('PayBot');
        }
        return $this->payBot;
    }

    /**
     * @param PayBotInterface $payBot
     */
    public function setPayBot(PayBotInterface $payBot): void
    {
        $this->payBot = $payBot;
    }

    /**
     * @return ChequesTextRepositoryInterface
     *
     * @throws DiException
     */
    public function getChequesTextRepository(): ChequesTextRepositoryInterface
    {
        if (null === $this->chequesTextRepository) {
            throw new DiException('ChequesTextRepository');
        }
        return $this->chequesTextRepository;
    }

    /**
     * @param ChequesTextRepositoryInterface $chequesTextRepository
     */
    public function setChequesTextRepository(ChequesTextRepositoryInterface $chequesTextRepository): void
    {
        $this->chequesTextRepository = $chequesTextRepository;
    }

    /**
     * @return CreateChequeComponentInterface
     * @throws DiException
     */
    public function getCreateChequeComponent(): CreateChequeComponentInterface
    {
        if (null === $this->createChequeComponent) {
            throw new DiException('CreateChequeComponent');
        }
        return $this->createChequeComponent;
    }

    /**
     * @param CreateChequeComponentInterface $createChequeComponent
     */
    public function setCreateChequeComponent(CreateChequeComponentInterface $createChequeComponent): void
    {
        $this->createChequeComponent = $createChequeComponent;
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