<?php

declare(strict_types=1);

namespace System\Util\PayBot;

use System\Component\PayBot\PayBotInterface;
use System\Kernel\Protocol\AnswerMessage;

class ViberPayBot implements PayBotInterface
{
    public function sendUserMessage(AnswerMessage $answerMessage): void
    {
        // TODO: Implement sendAnswer() method.
    }

    public function sendPicture(AnswerMessage $answerMessage): void
    {
        // TODO: Implement sendPicture() method.
    }

    /**
     * @param AnswerMessage $answerMessage
     */
    public function updateKeyboard(AnswerMessage $answerMessage): void
    {
        // TODO: Implement updateKeyboard() method.
    }
}