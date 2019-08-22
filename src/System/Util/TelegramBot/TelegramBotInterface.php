<?php

declare(strict_types=1);

namespace System\Util\TelegramBot;

/**
 * Interface TelegramBotInterface
 * @package System\Util\TelegramBot
 */
interface TelegramBotInterface
{
    /**
     * @param int $chatId
     * @param string $text
     */
    public function sendMessage(string $text, int $chatId = 0);
}
