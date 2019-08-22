<?php

declare(strict_types=1);

namespace System\Repository\Daemons;

use System\Entity\Repository\Daemon;

/**
 * Interface DaemonsRepositoryInterface
 * @package System\Repository\Daemons
 */
interface DaemonsRepositoryInterface
{
    /**
     * @param string $name
     * @return Daemon
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findDaemonByName(string $name): Daemon;
}
