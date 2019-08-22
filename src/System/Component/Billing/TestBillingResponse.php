<?php

declare(strict_types=1);

namespace System\Component\Billing;


class TestBillingResponse
{
    const KYIVSTAR_SUCCESS_RESPONSE = '{
                                          "Result": 10,
                                          "ChequeId": 7777,
                                          "PsId": -1,
                                          "Status": 21,
                                          "Time": "2019-05-30 10:14:08",
                                          "PaymentSystemId": 0,
                                          "Display": {
                                            "text": "Максимально допустима сума поповнень на сьогодні - 14999 грн.",
                                            "MaxPayAmount": 3000
                                          }
                                        }';
}