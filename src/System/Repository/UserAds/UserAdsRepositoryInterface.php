<?php

declare(strict_types=1);

namespace System\Repository\UserAds;

use System\Entity\Repository\UserAd;
use System\Exception\EmptyFetchResultException;

/**
 * Interface UserAdsRepositoryInterface
 * @package System\Repository\UserAds
 */
interface UserAdsRepositoryInterface
{
    /**
     * @param UserAd $userAd
     * @return int
     */
    public function save(UserAd $userAd): int;

    /**
     * @param int $recursionCyclesCount
     * @return string
     */
    public function generateGuid(int $recursionCyclesCount = 0): string;

    /**
     * @param string $guid
     * @param int $userId
     *
     * @return UserAd
     *
     * @throws EmptyFetchResultException
     */
    public function findByGuidUser(string $guid, int $userId = 0): UserAd;

    /**
     * @param int $userAdId
     * @param int $userId
     *
     * @return int
     */
    public function updateUserId(int $userAdId, int $userId): int;
}
