<?php

declare(strict_types=1);

namespace System\Repository\ChatsHistory;

use System\Entity\Repository\ChatHistory;
use System\Exception\EmptyFetchResultException;
use System\Repository\AbstractPdoRepository;

/**
 * Class ChatsHistoryRepository
 * @package System\Repository\ChatsHistory
 */
class ChatsHistoryRepository extends AbstractPdoRepository implements ChatsHistoryRepositoryInterface
{
    /**
     * @param ChatHistory $chatHistory
     * @return int
     * @throws \System\Exception\DiException
     */
    public function create(ChatHistory $chatHistory): int
    {
        $sql = 'insert into chats_history (chat_id, user_id, stage, sub_stage, localization, created_at, session_guid)
        values (:chatId, :userId, :stage, :subStage, :localization, :createdAt, :sessionGuid)';

        return $this->insert($sql, [
            'chatId' => $chatHistory->getChatId(),
            'userId' => $chatHistory->getUserId(),
            'stage' => $chatHistory->getStage(),
            'subStage' => $chatHistory->getSubStage(),
            'localization' => $chatHistory->getLocalization(),
            'createdAt' => $chatHistory->getCreatedAt(),
            'sessionGuid' => $chatHistory->getSessionGuid()
        ]);
    }

    /**
     * @param int $id
     *
     * @return ChatHistory
     *
     * @throws EmptyFetchResultException
     */
    public function findById(int $id): ChatHistory
    {
        $sql = 'select id, chat_id, user_id, stage, sub_stage, localization, created_at, session_guid
        from chats_history
        where id=:id';

        $row = $this->execAssocOne($sql, ['id' => $id]);
        return $this->inflate($row);
    }

    /**
     * @param array $row
     * @return ChatHistory
     */
    private function inflate(array $row): ChatHistory
    {
        return new ChatHistory(
            (int) $row['chat_id'],
            (int) $row['user_id'],
            (int) $row['stage'],
            (int) $row['sub_stage'],
            $row['localization'],
            $row['created_at'],
            $row['session_guid'],
            (int) $row['id']
        );
    }
}
