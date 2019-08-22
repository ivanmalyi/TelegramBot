<?php

declare(strict_types=1);

namespace System\Component;

use Predis\ClientInterface;
use System\Entity\Component\FlashNoticeTransport;
use System\Entity\Repository\Notification;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Repository\Notifications\NotificationsRepositoryInterface;
use System\Util\Logging\LoggerReferenceTrait;
use System\Util\MailClient\MailClientInterface;
use System\Util\TelegramBot\TelegramBotInterface;

/**
 * Class FlashNoticeComponent
 * @package System\Component
 */
class FlashNoticeComponent implements FlashNoticeComponentInterface
{
    use LoggerReferenceTrait;

    /**
     * @var TelegramBotInterface
     */
    private $telegramBot;

    /**
     * @var MailClientInterface
     */
    private $mailClient;

    /**
     * @var ClientInterface
     */
    private $redisClient;

    /**
     * @var NotificationsRepositoryInterface
     */
    private $notificationsRepository;

    /**
     * @return TelegramBotInterface
     * @throws DiException
     */
    public function getTelegramBot()
    {
        if ($this->telegramBot == null) {
            throw new DiException('TelegramBot');
        }
        return $this->telegramBot;
    }

    /**
     * @param TelegramBotInterface $telegramBot
     */
    public function setTelegramBot($telegramBot)
    {
        $this->telegramBot = $telegramBot;
    }

    /**
     * @return MailClientInterface
     * @throws DiException
     */
    public function getMailClient()
    {
        if ($this->mailClient == null) {
            throw new DiException('MailClient');
        }
        return $this->mailClient;
    }

    /**
     * @param MailClientInterface $mailClient
     */
    public function setMailClient($mailClient)
    {
        $this->mailClient = $mailClient;
    }

    /**
     * @return ClientInterface
     * @throws DiException
     */
    public function getRedisClient(): ClientInterface
    {
        if ($this->redisClient == null) {
            throw new DiException('RedisClient');
        }
        return $this->redisClient;
    }

    /**
     * @param ClientInterface $redisClient
     */
    public function setRedisClient(ClientInterface $redisClient)
    {
        $this->redisClient = $redisClient;
    }

    /**
     * @return NotificationsRepositoryInterface
     * @throws DiException
     */
    public function getNotificationsRepository(): NotificationsRepositoryInterface
    {
        if ($this->notificationsRepository == null) {
            throw new DiException('NotificationsRepository');
        }
        return $this->notificationsRepository;
    }

    /**
     * @param NotificationsRepositoryInterface $notificationsRepository
     */
    public function setNotificationsRepository(NotificationsRepositoryInterface $notificationsRepository): void
    {
        $this->notificationsRepository = $notificationsRepository;
    }

    /**
     * @param string $message
     * @param int $transport
     * @param array $parameters
     * @throws DiException
     */
    public function sendMessage(string $message, int $transport, array $parameters = [])
    {
        switch ($transport) {
            
            case FlashNoticeTransport::EMAIL:
                $emails = $this->findEmails($parameters);
                if (empty($emails)) {
                    $this->getLogger()->debug(
                        'FlashNotice email parameter not found',
                        $this->generateLogErrorContext($message)
                    );
                    break;
                }
                    
                $this->sendEmail($message, $emails);
                break;
            
            case FlashNoticeTransport::TELEGRAM:
                $this->getTelegramBot()->sendMessage($message);
                break;
            
            case FlashNoticeTransport::REDIS_EVENT:
                $eventData = $parameters;
                $eventData['message'] = $message;
                
                $this->getRedisClient()->lpush('events', [json_encode($eventData)]);
                break;
            
            default:
                $this->getLogger()->debug(
                    'FlashNotice transport not found with id '.$transport,
                    $this->generateLogErrorContext($message)
                );
        }
    }

    /**
     * @param string $message
     * @return array
     */
    private function generateLogErrorContext(string $message): array
    {
        return ['flash_notice' => $message, 'tags' => ['api', 'component', 'error']];
    }

    /**
     * @param array $parameters
     * @return array
     */
    private function findEmails(array $parameters): array
    {
        if (isset($parameters['emails']) and is_array($parameters['emails'])) {
            return $parameters['emails'];
        } elseif (isset($parameters['email']) and is_string($parameters['email'])) {
            return [$parameters['email']];
        }
        
        return [];
    }

    /**
     * @param string $message
     * @param array $emails
     */
    protected function sendEmail(string $message, array $emails)
    {
        foreach ($emails as $email) {
            try {
                $subject = "Flash Notice ".date('d.m.Y H:i:s');

                $message = new \Swift_Message($subject, $message);
                $message->setFrom($this->getMailClient()->getEmailFromAddress());
                $message->setTo($email);

                $this->getMailClient()->send($message);
            } catch (\Throwable $t) {
                $this->getLogger()->debug(
                    'FlashNotice email send error: '.$t->getMessage(),
                    ['flash_notice' => $message, 'tags' => ['api', 'component', 'error']]
                );
            }
        }
    }

    /**
     * @param Notification $notification
     * @throws DiException
     */
    public function sendNotification(Notification $notification): void
    {
        try {
            $fromSearch = $notification->getFromSearch() !== '' ? $notification->getFromSearch() : '';

            $this->getNotificationsRepository()->findNotification(
                $notification->getSource(),
                $notification->getMessage(),
                $fromSearch
            );
        } catch (EmptyFetchResultException $e) {
            $this->getNotificationsRepository()->create($notification);

            $this->sendMessage(
                $notification->getMessage(),
                $this->getTransportByNotification($notification)
            );
        }
    }

    /**
     * @param Notification $notification
     * @return int
     */
    private function getTransportByNotification(Notification $notification): int
    {
        if ($notification->getType() === Notification::EMAIL_TYPE) {
            return FlashNoticeTransport::EMAIL;
        } else {
            return FlashNoticeTransport::TELEGRAM;
        }
    }
}
