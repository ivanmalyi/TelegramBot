<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol;

/**
 * Class BillingResponseCode
 * @package System\Entity\InternalProtocol
 */
class ResponseCode
{
    const TRANSACTION_CANNOT_BE_CANCELED = -310;
    const PROVIDER_ERROR = -301;
    const UNKNOWN_PROVIDER = -300;
    const UNKNOWN_ERROR = -200;
    const DATA_NOT_FOUND = -121;
    const DATABASE_ERROR = -120;
    const WRONG_FORMAT = -110;
    const UNZIP_ERROR = -109;
    const MCC_NOT_SUPPORTED = -102;
    const DUPLICATE_COMMAND = -101;
    const UNKNOWN_COMMAND = -100;
    const AUTH_ERROR = -95;
    const ACCESS_DENIED_FOR_DOWNLOAD_KEYS = -93;
    const INVALID_SIGNATURE = -92;
    const INVALID_ARGUMENT = -91;
    const MISSING_ARGUMENT = -90;
    const BAD_PAYMENT_FORMULA = -26;
    const SUCCESS_ACTION = 10;
}
