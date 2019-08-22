<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol\Request\Telegram;

use System\Util\Validation\AnyString;
use System\Util\Validation\ArrayReaderAdapter;
use System\Util\Validation\PositiveInteger;


/**
 * Class Message
 * @package System\Entity\InternalProtocol\Request\Telegram
 */
class Message
{
    /**
     * @var int
     */
    private $messageId;

    /**
     * @var From
     */
    private $from;

    /**
     * @var Chat
     */
    private $chat;

    /**
     * @var int
     */
    private $date;

    /**
     * @var string
     */
    private $text;

    /**
     * @var ?Contact
     */
    private $contact;

    /**
     * Message constructor.
     * @param int $messageId
     * @param From $from
     * @param Chat $chat
     * @param int $date
     * @param string $text
     * @param Contact $contact
     */
    public function __construct(int $messageId, From $from, Chat $chat, int $date, string $text, Contact $contact = null)
    {
        $this->messageId = $messageId;
        $this->from = $from;
        $this->chat = $chat;
        $this->date = $date;
        $this->text = $text;
        $this->contact = $contact;
    }

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->messageId;
    }

    /**
     * @return From
     */
    public function getFrom(): From
    {
        return $this->from;
    }

    /**
     * @return Chat
     */
    public function getChat(): Chat
    {
        return $this->chat;
    }

    /**
     * @return int
     */
    public function getDate(): int
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getContact(): ?Contact
    {
        return $this->contact;
    }


    /**
     * @param array $message
     * @return Message
     * @throws \System\Exception\Protocol\MissingArgumentException
     * @throws \System\Exception\Protocol\ValidateArgumentException
     */
    public static function validation(array $message): Message
    {
        $reader = new ArrayReaderAdapter($message);

        return new Message(
            $reader->readWith(new PositiveInteger(), 'message_id'),
            From::validation($message['from']),
            Chat::validation($message['chat']),
            $reader->readWith(new PositiveInteger(), 'date'),
            isset($message['text']) ? $reader->readWith(new AnyString(), 'text'): '',
            isset($message['contact']) ? Contact::validation($message['contact']): null
        );
    }
}