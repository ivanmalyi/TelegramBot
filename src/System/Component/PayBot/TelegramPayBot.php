<?php

declare(strict_types=1);

namespace System\Component\PayBot;

use System\Kernel\Protocol\AnswerMessage;
use System\Util\Logging\LoggerReferenceTrait;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\HttpException;

/**
 * Class TelegramPayBot
 * @package System\Util\PayBot
 */
class TelegramPayBot extends BotApi implements PayBotInterface
{
    use LoggerReferenceTrait;
    /**
     * TelegramPayBot constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        parent::__construct($token);
    }

    /**
     * @param AnswerMessage $answerMessage
     * @throws \TelegramBot\Api\Exception
     * @throws \TelegramBot\Api\InvalidArgumentException
     */
    public function sendUserMessage(AnswerMessage $answerMessage): void
    {
        if (!empty($answerMessage->getMessage())) {
            $this->sendMessage(
                $answerMessage->getChatId(),
                $answerMessage->getMessage(),
                null,
                true,
                null,
                $answerMessage->getKeyboard()
            );
        }
    }

    /**
     * @param AnswerMessage $answerMessage
     * @throws \TelegramBot\Api\Exception
     * @throws \TelegramBot\Api\InvalidArgumentException
     */
    public function sendPicture(AnswerMessage $answerMessage): void
    {
        $this->sendPhoto(
            $answerMessage->getChatId(),
            $answerMessage->getPictureUrl(),
            $answerMessage->getMessage(),
            null,
            $answerMessage->getKeyboard()
        );
    }

    /**
     * @param AnswerMessage $answerMessage
     * @throws \TelegramBot\Api\Exception
     * @throws \TelegramBot\Api\InvalidArgumentException
     */
    public function updateKeyboard(AnswerMessage $answerMessage): void
    {
        try {
            $this->editMessageReplyMarkup(
                $answerMessage->getChatId(),
                $answerMessage->getMessageId(),
                $answerMessage->getKeyboard()
            );
        } catch (HttpException $e) {
            if (!empty($answerMessage->getMessage())) {
                $this->sendUserMessage($answerMessage);
            }
        }
    }
}