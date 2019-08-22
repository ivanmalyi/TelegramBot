<?php
declare(strict_types=1);

namespace System\Exception\Command;


use System\Entity\InternalProtocol\ResponseCode;

/**
 * Class PageNotFound
 * @package System\Exception\Command
 */
class PageNotFound extends CommandException
{
    /**
     * PageNotFound constructor.
     * @param int $pageType
     */
    public function __construct(int $pageType)
    {
        parent::__construct("Page with type {$pageType} not found", ResponseCode::DATA_NOT_FOUND);
    }
}