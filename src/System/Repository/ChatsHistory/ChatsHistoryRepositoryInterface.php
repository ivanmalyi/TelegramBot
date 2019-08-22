<?php

declare(strict_types=1);

namespace System\Repository\ChatsHistory;

use System\Entity\Repository\ChatHistory;
use System\Exception\EmptyFetchResultException;

/**
 * Interface ChatsHistoryRepositoryInterface
 * @package System\Repository\ChatsHistory
 */
interface ChatsHistoryRepositoryInterface
{
    /**
     * @param ChatHistory $chatHistory
     * @return int
     */
    public function create(ChatHistory $chatHistory): int;

    /**
     * @param int $id
     *
     * @return ChatHistory
     *
     * @throws EmptyFetchResultException
     */
    public function findById(int $id): ChatHistory;
}
