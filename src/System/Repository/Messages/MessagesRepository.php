<?php

declare(strict_types=1);

namespace System\Repository\Messages;


use System\Entity\Repository\Message;
use System\Repository\AbstractPdoRepository;

/**
 * Class MessagesRepository
 * @package System\Repository\Messages
 */
class MessagesRepository extends AbstractPdoRepository implements MessagesRepositoryInterface
{

    /**
     * @param int $stage
     * @param int $status
     *
     * @return Message
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function selectMessage(int $stage, int $status = 0): Message
    {
        $sql = 'select id, message, stage, status
                from messages
                where stage = :stage and status = :status';

        $row = $this->execAssocOne($sql, ['stage'=>$stage, 'status'=>$status]);

        return $this->inflate($row);
    }

    /**
     * @param $row
     *
     * @return Message
     */
    private function inflate($row): Message
    {
        return new Message(
            $row['message'],
            (int)$row['stage'],
            (int)$row['status'],
            (int)$row['id']
        );
    }
}