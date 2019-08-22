<?php

declare(strict_types=1);

namespace System\Exception\Command;


use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class PageIsOutOfDate
 * @package System\Exception\Command
 */
class PageOutDate extends CommandException
{

    /**
     * PageIsOutOfDate constructor.
     * @param int $pageId
     */
    public function __construct(int $pageId)
    {
        parent::__construct("Page with id {$pageId} is out of date", ResponseCode::AUTH_ERROR);
    }
}