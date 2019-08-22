<?php

declare(strict_types=1);

namespace System\Repository\Chats;

use System\Entity\Repository\Chat;
use System\Exception\EmptyFetchResultException;

/**
 * Interface ChatsRepositoryInterface
 * @package System\Repository\Chats
 */
interface ChatsRepositoryInterface
{
    /**
     * @param int $providerChatId
     * @param int $chatBotId
     *
     * @return Chat
     *
     * @throws EmptyFetchResultException
     */
    public function findByProviderChatId(int $providerChatId, int $chatBotId): Chat;

    /**
     * @param string $guid
     *
     * @return Chat
     *
     * @throws EmptyFetchResultException
     */
    public function findByPageGuid(string $guid): Chat;

    /**
     * @param int $chequeId
     * @return Chat
     */
    public function findByChequeId(int $chequeId): Chat;

    /**
     * @param int $chatId
     * @return Chat
     */
    public function findById(int $chatId): Chat;

    /**
     * @param Chat $chat
     * @return int
     */
    public function create(Chat $chat): int;

    /**
     * @param Chat $chat
     * @return int
     */
    public function updateCurrentStages(Chat $chat): int;

    /**
     * @param Chat $chat
     * @return int
     */
    public function updateCurrentSubStage(Chat $chat): int;

    /**
     * @param Chat $chat
     * @return int
     */
    public function updateCurrentInfo(Chat $chat): int;

    /**
     * @param int $chequeId
     * @return int
     */
    public function findItemIdByChequeId(int $chequeId): int;

    /**
     * @param Chat $chat
     *
     * @return int
     */
    public function updateAttempts(Chat $chat): int;
}
