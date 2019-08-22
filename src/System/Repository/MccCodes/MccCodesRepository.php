<?php

declare(strict_types=1);

namespace System\Repository\MccCodes;

use System\Entity\Repository\MccCode;
use System\Repository\AbstractPdoRepository;

/**
 * Class MccCodesRepository
 * @package System\Repository\MccCodes
 */
class MccCodesRepository extends AbstractPdoRepository implements MccCodesRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return MccCode
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findById(int $id): MccCode
    {
        $sql = 'select id, name, created_at from mcc_codes where id=:id';

        $row = $this->execAssocOne($sql, ['id' => $id]);

        return $this->inflate($row);
    }

    /**
     * @param array $row
     * @return MccCode
     */
    private function inflate(array $row): MccCode
    {
        return new MccCode(
            $row['name'],
            $row['created_at'],
            (int) $row['id']
        );
    }

    /**
     * @return array
     */
    public function findAllSupportedIds(): array
    {
        $sql = 'select id from mcc_codes';

        $rows = $this->execAssoc($sql, []);

        $result = [];
        foreach ($rows as $row) {
            $result[] = (int) $row['id'];
        }
        return $result;
    }
}
