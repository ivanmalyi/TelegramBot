<?php

declare(strict_types=1);

namespace System\Repository\ChequesCallbackUrls;

use System\Entity\Repository\ChequeCallbackUrl;
use System\Exception\EmptyFetchResultException;

/**
 * Interface ChequesCallbackUrlsRepositoryInterface
 * @package System\Repository\ChequesCallbackUrls
 */
interface ChequesCallbackUrlsRepositoryInterface
{
    /**
     * @param ChequeCallbackUrl $chequeCallbackUrl
     * @return int
     */
    public function create(ChequeCallbackUrl $chequeCallbackUrl): int;

    /**
     * @param string $guid
     *
     * @return ChequeCallbackUrl
     *
     * @throws EmptyFetchResultException
     */
    public function findByGuid(string $guid): ChequeCallbackUrl;

    /**
     * @param int $id
     * @param int $status
     * @return int
     */
    public function updateStatus(int $id, int $status): int;
}
