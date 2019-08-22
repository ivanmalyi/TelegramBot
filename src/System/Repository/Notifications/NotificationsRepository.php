<?php

declare(strict_types=1);

namespace System\Repository\Notifications;

use System\Entity\Repository\Notification;
use System\Exception\EmptyFetchResultException;
use System\Repository\AbstractPdoRepository;

/**
 * Class NotificationsRepository
 * @package System\Entity\Repository
 */
class NotificationsRepository extends AbstractPdoRepository implements NotificationsRepositoryInterface
{
    /**
     * @param string $source
     * @param string $message
     * @param string $fromTime
     * @return Notification
     *
     * @throws EmptyFetchResultException
     */
    public function findNotification(string $source, string $message, string $fromTime = ''): Notification
    {
        $sql = 'select id, source, type, created_at, message
          from notifications
          where source=:sourceCommand and message=:message';
        $params = [
            'sourceCommand' => $source,
            'message' => $message
        ];

        if ($fromTime !== '') {
            $sql .= ' and created_at >= :fromTime';
            $params['fromTime'] = $fromTime;
        }

        $rows = $this->execAssoc($sql, $params);
        if (empty($rows)) {
            throw new EmptyFetchResultException('Notification not found');
        }

        return $this->inflate(end($rows));
    }

    /**
     * @param array $row
     * @return Notification
     */
    private function inflate(array $row): Notification
    {
        return new Notification(
            $row['source'],
            $row['type'],
            $row['created_at'],
            $row['message'],
            (int) $row['id']
        );
    }

    /**
     * @param Notification $notification
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function create(Notification $notification): int
    {
        $sql = 'insert into notifications (source, type, created_at, message)
          values (:sourceCommand, :type, :createdAt, :message)';

        return $this->insert($sql, [
            'sourceCommand' => $notification->getSource(),
            'type' => $notification->getType(),
            'createdAt' => $notification->getCreatedAt(),
            'message' => $notification->getMessage()
        ]);
    }
}
