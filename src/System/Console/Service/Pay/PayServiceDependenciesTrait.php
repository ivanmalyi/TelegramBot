<?php

declare(strict_types=1);

namespace System\Console\Service\Pay;

use System\Component\Billing\BillingComponentInterface;
use System\Component\MessageProcessing\MessageProcessingComponentInterface;
use System\Component\PayBot\PayBotInterface;
use System\Exception\DiException;
use System\Repository\Chats\ChatsRepositoryInterface;
use System\Repository\Payments\PaymentsRepositoryInterface;
use System\Repository\PaymentsPrintData\PaymentsPrintDataRepositoryInterface;
use System\Repository\StagesMessages\StagesMessagesRepositoryInterface;

/**
 * Trait PayServiceDependenciesTrait
 * @package System\Console\Service\Pay
 */
trait PayServiceDependenciesTrait
{
    /**
     * @var PaymentsRepositoryInterface
     */
    private $paymentsRepository;

    /**
     * @var BillingComponentInterface
     */
    private $billingComponent;

    /**
     * @var ChatsRepositoryInterface
     */
    private $chatsRepository;

    /**
     * @var PayBotInterface
     */
    private $payBot;

    /**
     * @var StagesMessagesRepositoryInterface
     */
    private $stagesMessagesRepository;

    /**
     * @var PaymentsPrintDataRepositoryInterface
     */
    private $paymentsPrintDataRepository;

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
     * @return BillingComponentInterface
     * @throws DiException
     */
    public function getBillingComponent(): BillingComponentInterface
    {
        if (null === $this->billingComponent) {
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
     * @return PaymentsPrintDataRepositoryInterface
     * @throws DiException
     */
    public function getPaymentsPrintDataRepository(): PaymentsPrintDataRepositoryInterface
    {
        if (null === $this->paymentsPrintDataRepository) {
            throw new DiException('PaymentsPrintDataRepository');
        }
        return $this->paymentsPrintDataRepository;
    }

    /**
     * @param PaymentsPrintDataRepositoryInterface $paymentsPrintDataRepository
     */
    public function setPaymentsPrintDataRepository(PaymentsPrintDataRepositoryInterface $paymentsPrintDataRepository): void
    {
        $this->paymentsPrintDataRepository = $paymentsPrintDataRepository;
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
