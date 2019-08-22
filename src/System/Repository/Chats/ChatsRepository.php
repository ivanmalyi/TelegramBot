<?php

declare(strict_types=1);

namespace System\Repository\Chats;

use System\Entity\Repository\Chat;
use System\Exception\EmptyFetchResultException;
use System\Repository\AbstractPdoRepository;

/**
 * Class ChatsRepository
 * @package System\Repository\Chats
 */
class ChatsRepository extends AbstractPdoRepository implements ChatsRepositoryInterface
{
    /**
     * @param int $providerChatId
     * @param int $chatBotId
     *
     * @return Chat
     *
     * @throws EmptyFetchResultException
     */
    public function findByProviderChatId(int $providerChatId, int $chatBotId): Chat
    {
        $sql = 'select user_id, current_stage, current_sub_stage, current_cheque_id, current_localization,
            provider_chat_id, chat_bot_id, id, current_session_guid, phone, attempts
          from chats
          where provider_chat_id=:providerChatId and chat_bot_id=:chatBotId';

        $row = $this->execAssocOne($sql, ['providerChatId' => $providerChatId, 'chatBotId' => $chatBotId]);

        return $this->inflate($row);
    }

    /**
     * @param string $guid
     *
     * @return Chat
     *
     * @throws EmptyFetchResultException
     */
    public function findByPageGuid(string $guid): Chat
    {
        $sql = 'select h.user_id, h.current_stage, h.current_sub_stage, h.current_cheque_id, h.current_localization,
            h.provider_chat_id, h.chat_bot_id, h.id, h.current_session_guid, h.phone, attempts
          from cheques_callback_urls as ccu
            join cheques as c on ccu.cheque_id=c.id
            join chats as h on c.chat_id=h.id
          where ccu.guid=:pageGuid';

        $row = $this->execAssocOne($sql, ['pageGuid' => $guid]);

        return $this->inflate($row);
    }

    /**
     * @param int $chequeId
     *
     * @return Chat
     *
     * @throws EmptyFetchResultException
     */
    public function findByChequeId(int $chequeId): Chat
    {
        $sql = 'select h.user_id, h.current_stage, h.current_sub_stage, h.current_cheque_id, h.current_localization,
            h.provider_chat_id, h.chat_bot_id, h.id, h.current_session_guid, h.phone, attempts
          from cheques as c
            join chats as h on c.chat_id=h.id
          where c.id=:chequeId';

        $row = $this->execAssocOne($sql, ['chequeId' => $chequeId]);
        return $this->inflate($row);
    }

    /**
     * @param int $chatId
     *
     * @return Chat
     *
     * @throws EmptyFetchResultException
     */
    public function findById(int $chatId): Chat
    {
        $sql = 'select h.user_id, h.current_stage, h.current_sub_stage, h.current_cheque_id, h.current_localization,
            h.provider_chat_id, h.chat_bot_id, h.id, h.current_session_guid, h.phone, attempts
          from chats as h
          where h.id=:id';

        $row = $this->execAssocOne($sql, ['id' => $chatId]);
        return $this->inflate($row);
    }

    /**
     * @param array $row
     * @return Chat
     */
    private function inflate(array $row): Chat
    {
        return new Chat(
            (int) $row['user_id'],
            (int) $row['current_stage'],
            (int) $row['current_sub_stage'],
            (int) $row['current_cheque_id'],
            $row['current_localization'],
            (int) $row['provider_chat_id'],
            (int) $row['chat_bot_id'],
            $row['current_session_guid'],
            $row['phone'],
            (int) $row['attempts'],
            (int) $row['id']
        );
    }

    /**
     * @param Chat $chat
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function create(Chat $chat): int
    {
        $sql = 'insert into chats (user_id, current_stage, current_sub_stage, current_cheque_id,
            current_localization, provider_chat_id, current_session_guid, chat_bot_id, phone)
          values (:userId, :currentStage, :currentSubStage, :currentChequeId,
            :currentLocalization, :providerChatId, :currentSessionGuid, :chatBotId, :phone)';

        return $this->insert($sql, [
            'userId' => $chat->getUserId(),
            'currentStage' => $chat->getCurrentStage(),
            'currentSubStage' => $chat->getCurrentSubStage(),
            'currentChequeId' => $chat->getCurrentChequeId(),
            'currentLocalization' => $chat->getCurrentLocalization(),
            'providerChatId' => $chat->getProviderChatId(),
            'currentSessionGuid' => $chat->getCurrentSessionGuid(),
            'chatBotId' => $chat->getChatBotId(),
            'phone' => $chat->getPhone(),
        ]);
    }

    /**
     * @param Chat $chat
     *
     * @return int
     */
    public function updateCurrentStages(Chat $chat): int
    {
        $sql = 'update chats set current_stage=:stage, current_sub_stage=:currentSubStage where id=:id';

        return $this->update($sql, [
            'stage' => $chat->getCurrentStage(),
            'currentSubStage' => $chat->getCurrentSubStage(),
            'id' => $chat->getId()
        ]);
    }

    /**
     * @param Chat $chat
     * @return int
     */
    public function updateCurrentSubStage(Chat $chat): int
    {
        $sql = 'update chats set current_sub_stage=:subStage where id=:id';

        return $this->update($sql, [
            'subStage' => $chat->getCurrentSubStage(),
            'id' => $chat->getId()
        ]);
    }

    /**
     * @param Chat $chat
     * @return int
     */
    public function updateCurrentInfo(Chat $chat): int
    {
        $sql = 'update chats set';

        $sqlParams = [];
        $params = ['id' => $chat->getId()];

        if ($chat->getCurrentStage() !== 0) {
            $sqlParams[] = 'current_stage=:stage';
            $params['stage'] = $chat->getCurrentStage();
        }
        if ($chat->getCurrentSubStage() !== 0) {
            $sqlParams[] = 'current_sub_stage=:currentSubStage';
            $params['currentSubStage'] = $chat->getCurrentSubStage();
        }
        if ($chat->getCurrentChequeId() !== 0) {
            $sqlParams[] = 'current_cheque_id=:currentChequeId';
            $params['currentChequeId'] = $chat->getCurrentChequeId();
        }
        if ($chat->getCurrentLocalization() !== 0) {
            $sqlParams[] = 'current_localization=:currentLocalization';
            $params['currentLocalization'] = $chat->getCurrentLocalization();
        }
        if ($chat->getCurrentSessionGuid() !== '') {
            $sqlParams[] = 'current_session_guid=:currentSessionGuid';
            $params['currentSessionGuid'] = $chat->getCurrentSessionGuid();
        }

        if ($chat->getPhone() !== '') {
            $sqlParams[] = 'phone = :phone';
            $params['phone'] = $chat->getPhone();
        }

        if (empty($sqlParams)) {
            return 0;
        }

        $sql .= ' '.implode(',', $sqlParams);
        $sql .= ' where id=:id';

        return $this->update($sql, $params);
    }

    /**
     * @param int $chequeId
     *
     * @return int
     *
     * @throws EmptyFetchResultException
     */
    public function findItemIdByChequeId(int $chequeId): int
    {
        $sql = 'select item_id from cheques where id=:chequeId';

        $row = $this->execAssocOne($sql, ['chequeId' => $chequeId]);

        return (int) $row['item_id'];
    }

    /**
     * @param Chat $chat
     *
     * @return int
     */
    public function updateAttempts(Chat $chat): int
    {
        $sql = 'update chats set attempts = :attempts where id=:id';

        return $this->update($sql, [
            'attempts' => $chat->getAttempts(),
            'id' => $chat->getId()
        ]);
    }
}
