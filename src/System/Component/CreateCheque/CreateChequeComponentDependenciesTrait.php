<?php

declare(strict_types=1);

namespace System\Component\CreateCheque;


use System\Exception\DiException;
use System\Repository\Chats\ChatsRepositoryInterface;
use System\Repository\ChequePrint\ChequePrintRepositoryInterface;
use System\Repository\Cheques\ChequesRepositoryInterface;
use System\Repository\ItemsLocalization\ItemsLocalizationRepositoryInterface;
use System\Repository\PaymentsPurpose\PaymentsPurposeRepositoryInterface;
use System\Repository\PaymentSystemsHeadersLocalization\PaymentSystemsHeadersLocalizationRepositoryInterface;
use System\Repository\PointsInfo\PointsInfoRepositoryInterface;
use System\Repository\RecipientsTemplate\RecipientsTemplateRepositoryInterface;
use System\Repository\StagesMessages\StagesMessagesRepositoryInterface;

/**
 * Trait CreateChequeComponentDependenciesTrait
 * @package System\Component\CreateCheque
 */
trait CreateChequeComponentDependenciesTrait
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
     * @var RecipientsTemplateRepositoryInterface
     */
    private $recipientsTemplateRepository;

    /**
     * @var PointsInfoRepositoryInterface
     */
    private $pointsInfoRepository;

    /**
     * @var PaymentsPurposeRepositoryInterface
     */
    private $paymentsPurposeRepository;
    /**
     * @var ItemsLocalizationRepositoryInterface
     */
    private $itemsLocalizationRepository;

    /**
     * @var ChequesRepositoryInterface
     */
    private $chequesRepository;

    /**
     * @var PaymentSystemsHeadersLocalizationRepositoryInterface
     */
    private $paymentSystemsHeadersLocalizationRepository;

    /**
     * @var ChequePrintRepositoryInterface
     */
    private $chequePrintRepository;

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
     * @return RecipientsTemplateRepositoryInterface
     * @throws DiException
     */
    public function getRecipientsTemplateRepository(): RecipientsTemplateRepositoryInterface
    {
        if ($this->recipientsTemplateRepository === null) {
            throw new DiException('RecipientsTemplateRepository');
        }
        return $this->recipientsTemplateRepository;
    }

    /**
     * @param RecipientsTemplateRepositoryInterface $recipientsTemplateRepository
     */
    public function setRecipientsTemplateRepository(RecipientsTemplateRepositoryInterface $recipientsTemplateRepository): void
    {
        $this->recipientsTemplateRepository = $recipientsTemplateRepository;
    }

    /**
     * @return PointsInfoRepositoryInterface
     * @throws DiException
     */
    public function getPointsInfoRepository(): PointsInfoRepositoryInterface
    {
        if (null === $this->pointsInfoRepository) {
            throw new DiException('PointsInfoRepository');
        }
        return $this->pointsInfoRepository;
    }

    /**
     * @param PointsInfoRepositoryInterface $pointsInfoRepository
     */
    public function setPointsInfoRepository(PointsInfoRepositoryInterface $pointsInfoRepository): void
    {
        $this->pointsInfoRepository = $pointsInfoRepository;
    }

    /**
     * @return PaymentsPurposeRepositoryInterface
     *
     * @throws DiException
     */
    public function getPaymentsPurposeRepository(): PaymentsPurposeRepositoryInterface
    {
        if ($this->paymentsPurposeRepository === null) {
            throw new DiException('PaymentsPurposeRepository');
        }
        return $this->paymentsPurposeRepository;
    }

    /**
     * @param PaymentsPurposeRepositoryInterface $paymentsPurposeRepository
     */
    public function setPaymentsPurposeRepository(PaymentsPurposeRepositoryInterface $paymentsPurposeRepository): void
    {
        $this->paymentsPurposeRepository = $paymentsPurposeRepository;
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
     * @return PaymentSystemsHeadersLocalizationRepositoryInterface
     *
     * @throws DiException
     */
    public function getPaymentSystemsHeadersLocalizationRepository(): PaymentSystemsHeadersLocalizationRepositoryInterface
    {
        if ($this->paymentSystemsHeadersLocalizationRepository === null) {
            throw new DiException('PaymentSystemsHeadersLocalizationRepository');
        }
        return $this->paymentSystemsHeadersLocalizationRepository;
    }

    /**
     * @param PaymentSystemsHeadersLocalizationRepositoryInterface $chequesRepository
     */
    public function setPaymentSystemsHeadersLocalizationRepository(PaymentSystemsHeadersLocalizationRepositoryInterface $chequesRepository): void
    {
        $this->paymentSystemsHeadersLocalizationRepository = $chequesRepository;
    }

    /**
     * @return ChequePrintRepositoryInterface
     * @throws DiException
     */
    public function getChequePrintRepository(): ChequePrintRepositoryInterface
    {
        if ($this->chequePrintRepository === null) {
            throw new DiException('ChequePrintRepository');
        }
        return $this->chequePrintRepository;
    }

    /**
     * @param ChequePrintRepositoryInterface $chequePrintRepository
     */
    public function setChequePrintRepository(ChequePrintRepositoryInterface $chequePrintRepository): void
    {
        $this->chequePrintRepository = $chequePrintRepository;
    }
}