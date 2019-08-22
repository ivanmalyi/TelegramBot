<?php

declare(strict_types=1);

namespace System\Repository\Notifications;

use System\Entity\Repository\Notification;
use System\Exception\EmptyFetchResultException;

/**
 * Interface NotificationsRepositoryInterface
 * @package System\Repository
 */
interface NotificationsRepositoryInterface
{
    /**
     * @param string $source
     * @param string $message
     * @param string $fromTime
     * @return Notification
     *
     * @throws EmptyFetchResultException
     */
    public function findNotification(string $source, string $message, string $fromTime = ''): Notification;

    /**
     * @param Notification $notification
     * @return int
     */
    public function create(Notification $notification): int;
}
