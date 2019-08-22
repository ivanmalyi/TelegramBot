<?php

include_once __DIR__.'/../vendor/autoload.php';

use System\Kernel\ConsoleService\ConsoleService;

$consoleService = new ConsoleService(
    __DIR__ . '/../config',
    $argv[1],
    $argv
);

$consoleService->run();
