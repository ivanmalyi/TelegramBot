<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol\Request\Telegram;
use System\Util\Validation\AnyString;
use System\Util\Validation\ArrayReaderAdapter;
use System\Util\Validation\BooleanArgument;
use System\Util\Validation\IntegerInRange;
use System\Util\Validation\NotEmptyString;


/**
 * Class From
 * @package System\Entity\InternalProtocol\Request\Telegram
 */
class From
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var bool
     */
    private $isBot;

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
    private $username;

    /**
     * @var string
     */
    private $languageCode;

    /**
     * From constructor.
     * @param int $id
     * @param bool $isBot
     * @param string $firstName
     */
    public function __construct(int $id, bool $isBot, string $firstName)
    {
        $this->id = $id;
        $this->isBot = $isBot;
        $this->firstName = $firstName;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isBot(): bool
    {
        return $this->isBot;
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
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }

    /**
     * @param string $languageCode
     */
    public function setLanguageCode(string $languageCode): void
    {
        $this->languageCode = $languageCode;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param array $from
     * @return From
     * @throws \System\Exception\Protocol\MissingArgumentException
     * @throws \System\Exception\Protocol\ValidateArgumentException
     */
    public static function validation(array $from): From
    {
        $reader = new ArrayReaderAdapter($from);

        $fromObject = new From(
            $reader->readWith(new IntegerInRange(-9999999999, 9999999999), 'id'),
            $reader->readWith(new BooleanArgument(), 'is_bot'),
            $reader->readWith(new NotEmptyString(), 'first_name')
        );

        $fromObject->setUsername(isset($from['username']) ? $reader->readWith(new AnyString(), 'username'): '');
        $fromObject->setLastName(isset($from['last_name']) ? $reader->readWith(new AnyString(), 'last_name'): '');
        $fromObject->setLanguageCode(isset($from['language_code']) ? $reader->readWith(new AnyString(), 'language_code'): 'ru');

        return $fromObject;
    }
}