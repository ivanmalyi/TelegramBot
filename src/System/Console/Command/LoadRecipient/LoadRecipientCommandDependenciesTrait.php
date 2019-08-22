<?php

declare(strict_types=1);

namespace System\Console\Command\LoadRecipient;

use System\Repository\Recipients\RecipientsRepositoryInterface;
use System\Repository\RecipientsTemplate\RecipientsTemplateRepositoryInterface;
use System\Exception\DiException;

trait LoadRecipientCommandDependenciesTrait
{
    /**
     * @var RecipientsRepositoryInterface
     */
    private $recipientsRepository;

    /**
     * @var RecipientsTemplateRepositoryInterface
     */
    private $recipientsTemplateRepository;

    /**
     * @return RecipientsRepositoryInterface
     * @throws DiException
     */
    public function getRecipientsRepository(): RecipientsRepositoryInterface
    {
        if ($this->recipientsRepository === null) {
            throw new DiException('RecipientsRepository');
        }
        return $this->recipientsRepository;
    }

    /**
     * @param RecipientsRepositoryInterface $recipientsRepository
     */
    public function setRecipientsRepository(RecipientsRepositoryInterface $recipientsRepository): void
    {
        $this->recipientsRepository = $recipientsRepository;
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
}
