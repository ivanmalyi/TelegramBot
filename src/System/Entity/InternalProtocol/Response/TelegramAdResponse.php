<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol\Response;

/**
 * Class TelegramAdResponse
 * @package System\Entity\InternalProtocol\Response
 */
class TelegramAdResponse
{
    /**
     * @var string
     */
    private $guid;

    /**
     * TelegramAdResponse constructor.
     * @param string $guid
     */
    public function __construct(string $guid)
    {
        $this->guid = $guid;
    }

    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }
}
