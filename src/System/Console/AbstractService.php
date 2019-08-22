<?php

declare(strict_types=1);

namespace System\Console;

use System\Entity\InternalProtocol\ResponseCode;
use System\Entity\Repository\Daemon;
use System\Exception\DiException;
use System\Exception\Protocol\DaemonNotActiveException;
use System\Kernel\Protocol\AnswerBundle;
use System\Kernel\Protocol\CommandLinePacket;

/**
 * Class AbstractService
 * @package System\Console
 */
abstract class AbstractService extends AbstractCommand
{
    /**
     * Seconds
     * @var int
     */
    protected $sleep = 1 * 60;

    /**
     * @var string
     */
    protected $serviceName = '';

    /**
     * @param CommandLinePacket $packet
     * @return AnswerBundle
     */
    public function handle(CommandLinePacket $packet): AnswerBundle
    {
        try {
            while (true) {
                $start = microtime(true);

                $this->doService($packet);

                $delta = (microtime(true) - $start);
                $sleepTime = (int) round(($this->sleep - $delta) * 1000000);

                if ($sleepTime > 0) {
                    usleep($sleepTime);
                }
            }
        } catch (DaemonNotActiveException $e) {
            $this->getLogger()->info('Daemon <'.$e->getMessage().'> has disable status: try daemon to stop');
        }

        return new AnswerBundle(["Result" => ResponseCode::SUCCESS_ACTION]);
    }

    /**
     * @throws DaemonNotActiveException
     * @throws DiException
     */
    protected function checkForDaemonIsActive()
    {
        $daemonStatus = $this->getDaemonComponent()->getStatus($this->serviceName);
        if ($daemonStatus == Daemon::DISABLE_STATUS) {
            throw new DaemonNotActiveException($this->serviceName);
        }
    }

    /**
     * @param CommandLinePacket $packet
     * @return void
     * @throws DaemonNotActiveException
     */
    abstract protected function doService(CommandLinePacket $packet);
}
