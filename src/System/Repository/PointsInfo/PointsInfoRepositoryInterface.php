<?php

declare(strict_types=1);

namespace System\Repository\PointsInfo;


use System\Entity\Component\Billing\Response\LoadInformationResponse;
use System\Entity\Repository\PointInfo;

/**
 * Interface PointsInfoRepositoryInterface
 * @package System\Repository\PointsInfo
 */
interface PointsInfoRepositoryInterface
{
    /**
     * @return PointInfo
     */
    public function findPointInfo(): PointInfo;

    /**
     * @param LoadInformationResponse $loadInformationResponse
     *
     * @return int
     */
    public function savePointInfo(LoadInformationResponse $loadInformationResponse): int;

    /**
     * @return int
     */
    public function deleteAll(): int;
}