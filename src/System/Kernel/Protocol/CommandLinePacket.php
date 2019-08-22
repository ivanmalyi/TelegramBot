<?php

declare(strict_types=1);

namespace System\Kernel\Protocol;

use System\Util\ConverterClass\ToStringTrait;

/**
 * Class CommandLinePacket
 * @package System\Kernel\Protocol
 */
class CommandLinePacket
{
    use ToStringTrait;

    /**
     * @var string
     */
    private $command;

    /**
     * @var array
     */
    private $data;

    /**
     * CommandLinePacket constructor.
     * @param string $command
     * @param array $data
     */
    public function __construct(string $command, array $data)
    {
        $this->command = $command;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getCommand() : string
    {
        return $this->command;
    }

    /**
     * @return array
     */
    public function getData() : array
    {
        return $this->data;
    }
}
