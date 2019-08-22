<?php

declare(strict_types=1);
namespace System\Facade\LoadAmount;


class LoadAmountFacadeSubStage
{
    const DEFAULT = 0;
    const MESSAGE_FOUND = 1;
    const CHEQUE_IS_CORRECT = 2;
    const LITTLE_AMOUNT = 3;
    const LARGE_AMOUNT = 4;
    const INVALID_AMOUNT = 5;
}