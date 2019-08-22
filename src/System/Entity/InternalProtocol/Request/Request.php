<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol\Request;

/**
 * Class Request
 * @package System\Entity\InternalProtocol\Request
 */
class Request
{
    /**
     * @var string
     */
    private $command;

    /**
     * Request constructor.
     * @param string $command
     */
    public function __construct(string $command)
    {
        $this->command = $command;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }
}
