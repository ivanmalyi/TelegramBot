<?php

declare(strict_types=1);

namespace System\Repository\Messages;

use System\Entity\Repository\Message;

/**
 * Interface MessagesRepositoryInterface
 * @package System\Repository\Messages
 */
interface MessagesRepositoryInterface
{

    /**
     * @param int $stage
     * @param int $status
     * @return Message
     */
    public function selectMessage(int $stage, int $status = 0): Message;
}