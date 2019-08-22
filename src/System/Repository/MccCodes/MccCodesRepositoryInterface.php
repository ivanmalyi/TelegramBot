<?php

declare(strict_types=1);

namespace System\Repository\MccCodes;

use System\Entity\Repository\MccCode;

/**
 * Interface MccCodesRepositoryInterface
 * @package System\Repository\MccCodes
 */
interface MccCodesRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return MccCode
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findById(int $id): MccCode;

    /**
     * @return array
     */
    public function findAllSupportedIds(): array;
}
