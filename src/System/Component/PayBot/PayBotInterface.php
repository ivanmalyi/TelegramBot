<?php

declare(strict_types=1);

namespace System\Component\PayBot;

use System\Kernel\Protocol\AnswerMessage;

/**
 * Interface PayBotInterface
 * @package System\Kernel\Protocol
 */
interface PayBotInterface
{
    /**
     * @param AnswerMessage $answerMessage
     */
    public function sendUserMessage(AnswerMessage $answerMessage): void;

    /**
     * @param AnswerMessage $answerMessage
     */
    public function sendPicture(AnswerMessage $answerMessage): void;

    /**
     * @param AnswerMessage $answerMessage
     */
    public function updateKeyboard(AnswerMessage $answerMessage): void;
}