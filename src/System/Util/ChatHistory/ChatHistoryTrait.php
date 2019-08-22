<?php

declare(strict_types=1);

namespace System\Util\ChatHistory;

use System\Entity\Repository\Chat;
use System\Entity\Repository\ChatHistory;
use System\Exception\DiException;
use System\Repository\ChatsHistory\ChatsHistoryRepositoryInterface;

/**
 * Trait ChatHistoryTrait
 * @package System\Util\ChatHistory
 */
trait ChatHistoryTrait
{
    /**
     * @var ChatsHistoryRepositoryInterface
     */
    private $chatsHistoryRepository;

    /**
     * @return ChatsHistoryRepositoryInterface
     * @throws DiException
     */
    public function getChatsHistoryRepository(): ChatsHistoryRepositoryInterface
    {
        if (null === $this->chatsHistoryRepository) {
            throw new DiException('ChatsHistoryRepository');
        }
        return $this->chatsHistoryRepository;
    }

    /**
     * @param ChatsHistoryRepositoryInterface $chatsHistoryRepository
     */
    public function setChatsHistoryRepository(ChatsHistoryRepositoryInterface $chatsHistoryRepository): void
    {
        $this->chatsHistoryRepository = $chatsHistoryRepository;
    }

    /**
     * @param Chat $chat
     *
     * @return int
     *
     * @throws DiException
     */
    public function saveHistoryByChat(Chat $chat): int
    {
        return $this->getChatsHistoryRepository()->create(new ChatHistory(
            $chat->getId(),
            $chat->getUserId(),
            $chat->getCurrentStage(),
            $chat->getCurrentSubStage(),
            $chat->getCurrentLocalization(),
            date('Y-m-d H:i:s'),
            $chat->getCurrentSessionGuid()
        ));
    }
}
