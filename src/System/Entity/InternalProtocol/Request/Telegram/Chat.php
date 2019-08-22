<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol\Request\Telegram;
use System\Util\Validation\AnyString;
use System\Util\Validation\ArrayReaderAdapter;
use System\Util\Validation\IntegerInRange;
use System\Util\Validation\NotEmptyString;


/**
 * Class Chat
 * @package System\Entity\InternalProtocol\Request\Telegram
 */

/**
 * Class Chat
 * @package System\Entity\InternalProtocol\Request\Telegram
 */
class Chat
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $username;

    /**
     * Chat constructor.
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param string $type
     * @param string $username
     */
    public function __construct(int $id, string $firstName, string $lastName, string $type, string $username)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->type = $type;
        $this->username = $username;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param array $chat
     * @return Chat
     * @throws \System\Exception\Protocol\MissingArgumentException
     * @throws \System\Exception\Protocol\ValidateArgumentException
     */
    public static function validation(array $chat): Chat
    {
        $reader = new ArrayReaderAdapter($chat);

        return new Chat(
            $reader->readWith(new IntegerInRange(-9999999999, 9999999999), 'id'),
            isset($chat['first_name']) ? $reader->readWith(new AnyString(), 'first_name') : '',
            isset($chat['last_name']) ? $reader->readWith(new AnyString(), 'last_name') : '',
            $reader->readWith(new NotEmptyString(), 'type'),
            isset($chat['username']) ? $reader->readWith(new AnyString(), 'username') : ''
        );
    }
}