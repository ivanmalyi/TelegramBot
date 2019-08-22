<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol\Request;

/**
 * Class TelegramCallbackRequest
 * @package System\Entity\InternalProtocol\Request
 */
class TelegramCallbackRequest
{
    /**
     * @var string
     */
    private $pageGuid;

    /**
     * @var string
     */
    private $message;

    /**
     * TelegramCallbackRequest constructor.
     * @param string $pageGuid
     * @param string $message
     */
    public function __construct(string $pageGuid, string $message = '')
    {
        $this->pageGuid = $pageGuid;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getPageGuid(): string
    {
        return $this->pageGuid;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
