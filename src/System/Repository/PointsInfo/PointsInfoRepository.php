<?php

declare(strict_types=1);

namespace System\Repository\PointsInfo;


use System\Entity\Component\Billing\Response\LoadInformationResponse;
use System\Entity\Repository\PointInfo;
use System\Repository\AbstractPdoRepository;

/**
 * Class PointsInfoRepository
 * @package System\Repository\PointsInfo
 */
class PointsInfoRepository extends AbstractPdoRepository implements PointsInfoRepositoryInterface
{
    /**
     * @return PointInfo
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findPointInfo(): PointInfo
    {
        $sql = "select id, member_id, point_id, address, place, add_info
                from points_info
                order by id desc limit 1";

        $row = $this->execAssocOne($sql, []);

        return $this->inflate($row);
    }

    /**
     * @param array $row
     *
     * @return PointInfo
     */
    private function inflate(array $row): PointInfo
    {
        return new PointInfo(
            (int)$row['member_id'],
            (int)$row['point_id'],
            $row['address'],
            $row['place'],
            $row['add_info'],
            (int)$row['id']
        );
    }

    /**
     * @param LoadInformationResponse $loadInformationResponse
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function savePointInfo(LoadInformationResponse $loadInformationResponse): int
    {
        $sql = 'insert into points_info (member_id, point_id, address, place, add_info) 
                value (:memberId, :pointId, :address, :place, :addInfo)';

        $placeholders = [
            'memberId'=>$loadInformationResponse->getMemberId(),
            'pointId'=>$loadInformationResponse->getId(),
            'address'=>$loadInformationResponse->getAddress(),
            'place'=>$loadInformationResponse->getPlace(),
            'addInfo'=>$loadInformationResponse->getAddInfo(),
        ];

        return $this->insert($sql, $placeholders);
    }

    /**
     * @return int
     */
    public function deleteAll(): int
    {
        $sql = 'delete from points_info where id>0';

        return $this->update($sql, []);
    }
}