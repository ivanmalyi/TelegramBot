<?php

declare(strict_types=1);

namespace System\Component;

use System\Entity\Repository\Daemon;
use System\Exception\DiException;
use System\Repository\Daemons\DaemonsRepositoryInterface;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class DaemonComponent
 * @package System\Component
 */
class DaemonComponent implements DaemonComponentInterface
{
    use LoggerReferenceTrait;

    /**
     * @var DaemonsRepositoryInterface
     */
    private $daemonsRepository;

    /**
     * @return DaemonsRepositoryInterface
     * @throws DiException
     */
    public function getDaemonsRepository(): DaemonsRepositoryInterface
    {
        if ($this->daemonsRepository == null) {
            throw new DiException('DaemonsRepository');
        }
        return $this->daemonsRepository;
    }

    /**
     * @param DaemonsRepositoryInterface $daemonsRepository
     */
    public function setDaemonsRepository(DaemonsRepositoryInterface $daemonsRepository)
    {
        $this->daemonsRepository = $daemonsRepository;
    }

    /**
     * @param string $name
     * @return int
     */
    public function getStatus(string $name): int
    {
        try {
            return $this->getStatusFromRepository($name);
        } catch (\Throwable $t) {
            $this->getLogger()->debug("DaemonComponent: ".$t->getMessage());
            return Daemon::ACTIVE_STATUS;
        }
    }

    /**
     * @param string $name
     * @return int
     * @throws DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function getStatusFromRepository(string $name): int
    {
        $daemon = $this->getDaemonsRepository()->findDaemonByName($name);

        if ($daemon->getStatus() == Daemon::DISABLE_STATUS) {
            return Daemon::DISABLE_STATUS;
        }

        return Daemon::ACTIVE_STATUS;
    }
}
