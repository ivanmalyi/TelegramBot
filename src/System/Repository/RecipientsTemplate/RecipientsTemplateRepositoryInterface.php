<?php

declare(strict_types=1);

namespace System\Repository\RecipientsTemplate;

use System\Entity\Repository\RecipientForCheque;
use System\Entity\Repository\RecipientTemplate;

/**
 * Interface RecipientsTemplateRepositoryInterface
 * @package System\Repository\RecipientsTemplate
 */
interface RecipientsTemplateRepositoryInterface
{
    /**
     * @param RecipientTemplate $recipientTemplate
     * @return int
     */
    public function save(RecipientTemplate $recipientTemplate): int;

    /**
     * @return int
     */
    public function deleteAll(): int;

    /**
     * @param int $itemId
     * @param string $localization
     *
     * @return RecipientForCheque
     */
    public function findByItemId(int $itemId, string $localization): RecipientForCheque;
}
