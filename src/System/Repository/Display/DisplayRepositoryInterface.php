<?php

declare(strict_types=1);

namespace System\Repository\Display;


use System\Entity\Repository\Display;
use System\Exception\EmptyFetchResultException;
use System\Entity\Component\Billing\Display as VerifyDisplay;

/**
 * Interface DisplayRepositoryInterface
 * @package System\Repository\Display
 */
interface DisplayRepositoryInterface
{
    /**
     * @param VerifyDisplay $verifyDisplay
     * @param int $chequeId
     * @return int
     */
    public function saveDisplay(VerifyDisplay $verifyDisplay, int $chequeId): int;

    /**
     * @param int $chequeId
     *
     * @return Display
     *
     * @throws EmptyFetchResultException
     */
    public function findDisplayByChequeId(int $chequeId): Display;
}