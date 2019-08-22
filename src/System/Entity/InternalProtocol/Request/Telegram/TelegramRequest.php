<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol\Request\Telegram;

use System\Entity\InternalProtocol\Request\Request;
use System\Kernel\Protocol\RequestBundle;
use System\Util\Validation\ArrayReaderAdapter;
use System\Util\Validation\NotEmptyString;
use System\Util\Validation\PositiveInteger;

/**
 * Class TelegramRequest
 * @package System\Entity\InternalProtocol\Request\Telegram
 */
class TelegramRequest extends Request
{
    /**
     * @var int
     */
    private $updaetId;

    /**
     * @var Message
     */
    private $message;

    /**
     * @var CallbackData
     */
    private $callbackData;

    /**
     * TelegramRequest constructor.
     * @param int $updaetId
     * @param Message $message
     * @param string $command
     */
    public function __construct(int $updaetId, Message $message, string $command)
    {
        parent::__construct($command);
        $this->updaetId = $updaetId;
        $this->message = $message;
    }


    /**
     * @return int
     */
    public function getUpdaetId(): int
    {
        return $this->updaetId;
    }

    /**
     * @return Message
     */
    public function getMessage(): Message
    {
        return $this->message;
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
     * @param RequestBundle $requestBundle
     * @return TelegramRequest
     * @throws \System\Exception\Protocol\MissingArgumentException
     * @throws \System\Exception\Protocol\ValidateArgumentException
     */
    public static function validation(RequestBundle $requestBundle): TelegramRequest
    {
        $params = $requestBundle->getParams();
        $reader = new ArrayReaderAdapter($params);

        if (isset($params['callback_query'])) {
            $params['callback_query']['message']['from']['language_code'] = $params['callback_query']['from']['language_code'];
        }

        $telegramRequest = new TelegramRequest(
            $reader->readWith(new PositiveInteger(), 'update_id'),
            Message::validation($params['message'] ?? $params['callback_query']['message']),
            $reader->readWith(new NotEmptyString(), 'Command')
        );

        if (isset($params['callback_query']['data'])) {
            $data = json_decode($params['callback_query']['data'], true);
            $telegramRequest->setCallbackData(CallbackData::validation($data));
        }

        return $telegramRequest;
    }
}