<?php

declare(strict_types=1);

namespace System\Repository\Recipients;

use System\Entity\Repository\Recipient;

/**
 * Interface RecipientsRepositoryInterface
 * @package System\Repository\Recipients
 */
interface RecipientsRepositoryInterface
{
    /**
     * @param Recipient[] $recipients
     * @return int
     */
    public function saveAll(array $recipients): int;

    /**
     * @return int
     */
    public function deleteAll(): int;
}
