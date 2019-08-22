<?php

declare(strict_types=1);

namespace System\Repository\Daemons;

use System\Entity\Repository\Daemon;
use System\Repository\AbstractPdoRepository;

/**
 * Class DaemonsRepository
 * @package System\Repository\Daemons
 */
class DaemonsRepository extends AbstractPdoRepository implements DaemonsRepositoryInterface
{
    /**
     * @param string $name
     * @return Daemon
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findDaemonByName(string $name): Daemon
    {
        $sql = 'select id, status, name from daemons where name = :name';

        $row = $this->execAssocOne($sql, ['name' => $name]);

        return $this->inflate($row);
    }

    /**
     * @param array $row
     * @return Daemon
     */
    private function inflate(array $row): Daemon
    {
        return new Daemon(
            $row['name'],
            (int) $row['status'],
            (int) $row['id']
        );
    }
}
