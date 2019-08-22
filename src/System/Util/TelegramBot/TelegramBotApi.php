<?php

declare(strict_types=1);

namespace System\Util\TelegramBot;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

/**
 * Class TelegramBotApi
 * @package System\Util\TelegramBot
 */
class TelegramBotApi implements TelegramBotInterface
{
    /**
     * @var BotSettings
     */
    private $botSettings;

    /**
     * @param BotSettings $settings
     */
    public function setBotSettings(BotSettings $settings)
    {
        $this->botSettings = $settings;
    }

    /**
     * @return BotSettings
     */
    public function getBotSettings() : BotSettings
    {
        return $this->botSettings;
    }

    /**
     * @param string $text
     * @param int $chatId
     */
    public function sendMessage(string $text, int $chatId = 0)
    {
        try {
            $data['text'] = $text;
            
            if ($chatId === 0) {
                $data['chat_id'] = $this->getBotSettings()->getChatId();
            } else {
                $data['chat_id'] = $chatId;
            }


            $request = new Request();
            $request->initialize(new Telegram($this->getBotSettings()->getApiKey()));
            $request->sendMessage($data);
        } catch (\Throwable $e) {}
    }
}
