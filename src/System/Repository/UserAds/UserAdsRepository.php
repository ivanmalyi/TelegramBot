<?php

declare(strict_types=1);

namespace System\Repository\UserAds;

use System\Entity\Repository\UserAd;
use System\Exception\EmptyFetchResultException;
use System\Exception\Protocol\UnknownCommandException;
use System\Repository\AbstractPdoRepository;

/**
 * Class UserAdsRepository
 * @package System\Repository\UserAds
 */
class UserAdsRepository extends AbstractPdoRepository implements UserAdsRepositoryInterface
{
    const MAX_RECURSION_CYCLES_COUNT = 10;

    /**
     * @param UserAd $userAd
     * @return int
     * @throws \System\Exception\DiException
     */
    public function save(UserAd $userAd): int
    {
        $sql = 'insert into user_ads (user_id, guid, utm_source, utm_medium, utm_term, utm_content, utm_campaign,
          ref_original, created_at, updated_at)
        values (:userId, :guid, :utmSource, :utmMedium, :utmTerm, :utmContent, :utmCampaign,
          :refOriginal, :createdAt, :updatedAt)';

        return $this->insert($sql, [
            'userId' => $userAd->getUserId(),
            'guid' => $userAd->getGuid(),
            'utmSource' => $userAd->getUtmSource(),
            'utmMedium' => $userAd->getUtmMedium(),
            'utmTerm' => $userAd->getUtmTerm(),
            'utmContent' => $userAd->getUtmContent(),
            'utmCampaign' => $userAd->getUtmCampaign(),
            'refOriginal' => $userAd->getRefOriginal(),
            'createdAt' => $userAd->getCreatedAt(),
            'updatedAt' => $userAd->getUpdatedAt()
        ]);
    }

    /**
     * @param int $recursionCyclesCount
     *
     * @return string
     *
     * @throws UnknownCommandException
     */
    public function generateGuid(int $recursionCyclesCount = 0): string
    {
        if ($recursionCyclesCount > self::MAX_RECURSION_CYCLES_COUNT) {
            throw new UnknownCommandException('Cannot generate unique guid');
        }
        $guid = sprintf(
            '%04X%04X%04X%04X',
            mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535)
        );

        try {
            $this->findByGuidUser($guid);

            usleep(100000);
            return $this->generateGuid($recursionCyclesCount+1);
        } catch (EmptyFetchResultException $e) {
            return $guid;
        }
    }

    /**
     * @param string $guid
     * @param int $userId
     * @return UserAd
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findByGuidUser(string $guid, int $userId = 0): UserAd
    {
        $sql = 'select id, user_id, guid, utm_source, utm_medium, utm_term, utm_content, utm_campaign,
            ref_original, created_at, updated_at
          from user_ads
          where guid=:guid and user_id=:userId';

        $row = $this->execAssocOne($sql, ['guid' => $guid, 'userId' => $userId]);

        return $this->inflate($row);
    }

    /**
     * @param array $row
     * @return UserAd
     */
    private function inflate(array $row): UserAd
    {
        return new UserAd(
            (int) $row['user_id'],
            $row['guid'],
            $row['utm_source'],
            $row['utm_medium'],
            $row['utm_term'],
            $row['utm_content'],
            $row['utm_campaign'],
            $row['ref_original'],
            $row['created_at'],
            $row['updated_at'],
            (int) $row['id']
        );
    }

    /**
     * @param int $userAdId
     * @param int $userId
     *
     * @return int
     */
    public function updateUserId(int $userAdId, int $userId): int
    {
        $sql = 'update user_ads 
                set user_id = :userId, updated_at = now()
                where id = :userAdId';

        return $this->update($sql, ['userId' => $userId, 'userAdId' => $userAdId]);
    }
}
