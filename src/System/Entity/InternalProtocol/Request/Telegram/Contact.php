<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol\Request\Telegram;
use System\Util\Validation\AnyString;
use System\Util\Validation\ArrayReaderAdapter;
use System\Util\Validation\IntegerInRange;
use System\Util\Validation\NotEmptyString;


/**
 * Class Contact
 * @package System\Entity\InternalProtocol\Request\Telegram
 */
class Contact
{
    /**
     * @var string
     */
    private $phoneNumber;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var int
     */
    private $userId;

    /**
     * Contact constructor.
     * @param string $phoneNumber
     * @param string $firstName
     * @param string $lastName
     * @param int $userId
     */
    public function __construct(string $phoneNumber, string $firstName, string $lastName, int $userId)
    {
        $this->phoneNumber = $phoneNumber;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
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
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param array $contact
     *
     * @return Contact
     *
     * @throws \System\Exception\Protocol\MissingArgumentException
     * @throws \System\Exception\Protocol\ValidateArgumentException
     */
    public static function validation(array $contact): Contact
    {
        $reader = new ArrayReaderAdapter($contact);

        return new self(
            $reader->readWith(new NotEmptyString(), 'phone_number'),
            $reader->readWith(new NotEmptyString(), 'first_name'),
            isset($chat['last_name']) ? $reader->readWith(new AnyString(), 'last_name') : '',
            $reader->readWith(new IntegerInRange(-9999999999, 9999999999), 'user_id')
        );
    }
}