<?php

declare(strict_types=1);

namespace System\Exception\Protocol;

use System\Entity\InternalProtocol\ResponseCode;

class AccessDeniedForDownloadKeysException extends ProtocolException
{
    public function __construct()
    {
        parent::__construct("Access denied for download keys", ResponseCode::ACCESS_DENIED_FOR_DOWNLOAD_KEYS);
    }
}
