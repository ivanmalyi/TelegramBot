<?php

declare(strict_types=1);

namespace System\Kernel\Protocol;


use System\Entity\Component\Billing\Response\VerifyResponse;
use System\Entity\InternalProtocol\Request\Telegram\CallbackData;

/**
 * Class AnswerMessage
 * @package System\Action
 */
class AnswerMessage
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var int
     */
    private $chatId;

    /**
     * @var ?object
     */
    private $keyboard = null;

    /**
     * @var bool
     */
    private $isPicture;

    /**
     * @var string
     */
    private $pictureUrl;

    /**
     * @var int
     */
    private $goToStage;

    /**
     * @var null|CallbackData
     */
    private $callbackData;

    /**
     * @var int
     */
    private $messageId;

    /**
     * @var bool
     */
    private $isUpdateKeyboard;

    /**
     * @var VerifyResponse
     */
    private $verifyResponse;

    /**
     * AnswerMessage constructor.
     * @param int $chatId
     * @param int$messageId
     * @param bool $isPicture
     * @param string $pictureUrl
     */
    public function __construct(
        int $chatId,
        int $messageId = 0,
        bool $isPicture = false,
        string $pictureUrl = ''
    )
    {
        $this->chatId = $chatId;
        $this->messageId = $messageId;
        $this->isPicture = $isPicture;
        $this->pictureUrl = $pictureUrl;
        $this->goToStage = 0;
        $this->callbackData = null;
        $this->message = '';
        $this->isUpdateKeyboard = false;
    }


    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chatId;
    }

    /**
     * @return bool
     */
    public function isPicture(): bool
    {
        return $this->isPicture;
    }

    /**
     * @param bool $isPicture
     */
    public function setIsPicture(bool $isPicture): void
    {
        $this->isPicture = $isPicture;
    }

    /**
     * @return string
     */
    public function getPictureUrl(): string
    {
        return $this->pictureUrl;
    }

    /**
     * @param string $pictureUrl
     */
    public function setPictureUrl(string $pictureUrl): void
    {
        $this->pictureUrl = $pictureUrl;
    }

    /**
     * @return mixed
     */
    public function getKeyboard()
    {
        return $this->keyboard;
    }

    /**
     * @param mixed $keyboard
     */
    public function setKeyboard($keyboard): void
    {
        $this->keyboard = $keyboard;
    }

    /**
     * @return int
     */
    public function getGoToStage(): int
    {
        return $this->goToStage;
    }

    /**
     * @param int $goToStage
     */
    public function setGoToStage(int $goToStage): void
    {
        $this->goToStage = $goToStage;
    }

    /**
     * @return null|CallbackData
     */
    public function getCallbackData(): ?CallbackData
    {
        return $this->callbackData;
    }

    /**
     * @param CallbackData $callbackData
     */
    public function setCallbackData(CallbackData $callbackData): void
    {
        $this->callbackData = $callbackData;
    }

    /**
     * @return bool
     */
    public function isUpdateKeyboard(): bool
    {
        return $this->isUpdateKeyboard;
    }

    /**
     * @param bool $isUpdateKeyboard
     */
    public function setIsUpdateKeyboard(bool $isUpdateKeyboard): void
    {
        $this->isUpdateKeyboard = $isUpdateKeyboard;
    }

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->messageId;
    }
}
