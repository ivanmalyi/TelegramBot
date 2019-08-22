<?php

include_once __DIR__.'/../vendor/autoload.php';

use System\Kernel\MessageService\MessageService;
use TelegramBot\Api\BotApi;

$systemService = new MessageService(
    __DIR__ . '/../config',
    getenv('ENVIRONMENT') !== false ? getenv('ENVIRONMENT') : 'dev'
);

$systemService->run();
