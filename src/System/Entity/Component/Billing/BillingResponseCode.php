<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing;

/**
 * Class BillingResponseCode
 * @package System\Entity\Component\Billing
 */
class BillingResponseCode
{
    const CURL_ERROR = -300;
    const UNKNOWN_ERROR = -200;
    const MP_CARD_ID_HAS_EXPIRED = -135;
    const MP_CARD_ID_HAS_USED = -134;
    const MP_BAD_WALLET = -133;
    const MP_INVALID_CONFIRMATION_CODE = -132;
    const MP_WALLET_NOT_LINKED = -130;
    const PROMO_CODE_NOT_FOUND = -125;
    const DATABASE_ERROR = -120;
    const WRONG_FORMAT = -110;
    const UNZIP_ERROR = -109;
    const UNKNOWN_COMMAND = -100;
    const SERVICE_TEMPORARY_UNAVAILABLE = -99;
    const PROVIDER_NOT_FOUND = -98;
    const INVALID_SIGNATURE = -97;
    const CASHIER_AUTH_ERROR = -96;
    const AUTH_ERROR = -95;
    const LOW_BALANCE = -94;
    const INVALID_ARGUMENT = -93;
    const ACCESS_DENIED_FOR_CASHIER_AUTH = -92;
    const ACCESS_DENIED_FOR_DOWNLOAD_KEYS = -91;
    const MISSING_ARGUMENT = -90;
    const MCC_NOT_FOUND = -89;
    const ITEM_NOT_FOUND = -88;
    const SENDING_AUTH_CONFIRMATION_ERROR = -87;
    const BLOCKED_AUTH_USER_PASSWORD = -86;
    const AUTH_EXPIRED = -85;
    const COMMISSION_NOT_FOUND = -71;
    const COMMISSION_SETTING_NOT_FOUND = -70;
    const BAD_PAYMENT_STATUS_FOR_CANCEL = -63;
    const PROVIDER_DOES_NOT_SUPPORT_CANCEL = -62;
    const OUTDATED_CANCEL_PAYMENT = -61;
    const BAD_POINT_TYPE = -55;
    const ENCASHMENT_NOT_FOUND = -51;
    const DATA_NOT_FOUND = -50;
    const DATA_IS_DUPLICATED = -43;
    const MEMBER_CONTRACT_NOT_FOUND = -30;
    const TRANSACTION_NOT_FOUND = -29;
    const BAD_CHEQUE_FOR_CREATING_TRANSACTION = -28;
    const TRANSACTION_WITH_THIS_CHEQUE_DONE = -27;
    const TERMINAL_TRANSACTION_WITH_THIS_CHEQUE_DONE = 27;
    const BAD_PAYMENT_FORMULA = -26;
    const BAD_CHANGE_PAYMENT_TYPE = -24;
    const BAD_CHANGE_ACQUIRING_CONTRAGENT = -23;
    const SUCCESS_ACTION = 10;
    const SUCCESS_AUTH = 30;
    const CHECK_AUTH_USER_PASSWORD = 40;
    const ENCASHMENT_CLOSED = 50;
}
