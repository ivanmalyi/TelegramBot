<?php

declare(strict_types=1);

namespace System\Component;

use System\Entity\Repository\Notification;

/**
 * Interface FlashNoticeComponentInterface
 * @package System\Component
 */
interface FlashNoticeComponentInterface
{
    /**
     * @param string $message
     * @param int $transport
     * @param array $parameters
     */
    public function sendMessage(string $message, int $transport, array $parameters = []);

    /**
     * @param Notification $notification
     */
    public function sendNotification(Notification $notification): void;
}
