<?php

declare(strict_types=1);

namespace System\Util\TelegramBot;

/**
 * Class BotSettings
 * @package System\Util\TelegramBot
 */
class BotSettings
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $botName;

    /**
     * @var int
     */
    private $chatId;

    /**
     * BotSettings constructor.
     * @param string $apiKey
     * @param string $botName
     * @param int $chatId
     */
    public function __construct(string $apiKey, string $botName, int $chatId = 0)
    {
        $this->apiKey = $apiKey;
        $this->botName = $botName;
        $this->chatId = $chatId;
    }

    /**
     * @return string
     */
    public function getApiKey() : string
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getBotName() : string
    {
        return $this->botName;
    }

    /**
     * @return int
     */
    public function getChatId() : int
    {
        return $this->chatId;
    }
}
