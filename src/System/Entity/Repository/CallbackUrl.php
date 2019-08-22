<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class CallbackUrl
 * @package System\Entity\Repository
 */
class CallbackUrl
{
    /**
     * @var string
     */
    private $callbackUrl3ds;

    /**
     * @var string
     */
    private $callbackUrlOk;

    /**
     * @var string
     */
    private $callbackUrlError;

    /**
     * @var int
     */
    private $chatBotId;

    /**
     * @var int
     */
    private $id;

    /**
     * CallbackUrl constructor.
     * @param string $callbackUrl3ds
     * @param string $callbackUrlOk
     * @param string $callbackUrlError
     * @param int $chatBotId
     * @param int $id
     */
    public function __construct(
        string $callbackUrl3ds,
        string $callbackUrlOk,
        string $callbackUrlError,
        int $chatBotId,
        int $id = 0
    )
    {
        $this->callbackUrl3ds = $callbackUrl3ds;
        $this->callbackUrlOk = $callbackUrlOk;
        $this->callbackUrlError = $callbackUrlError;
        $this->chatBotId = $chatBotId;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCallbackUrl3ds(): string
    {
        return $this->callbackUrl3ds;
    }

    /**
     * @return string
     */
    public function getCallbackUrlOk(): string
    {
        return $this->callbackUrlOk;
    }

    /**
     * @return string
     */
    public function getCallbackUrlError(): string
    {
        return $this->callbackUrlError;
    }

    /**
     * @return int
     */
    public function getChatBotId(): int
    {
        return $this->chatBotId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}