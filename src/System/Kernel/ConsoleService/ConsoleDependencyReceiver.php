<?php

declare(strict_types=1);

namespace System\Kernel\ConsoleService;

use Predis\ClientInterface;
use Psr\Log\LoggerInterface;
use System\Component\FlashNoticeComponentInterface;
use System\Exception\DiException;
use System\Kernel\Protocol\FormatInterface;
use System\Kernel\Protocol\ProtocolInterface;

/**
 * Class ConsoleDependencyReceiver
 * @package SystemService\Kernel
 */
class ConsoleDependencyReceiver
{
    /**
     * @var ConsoleService
     */
    private $consoleService;

    /**
     * ConsoleDependencyReceiver constructor.
     * @param ConsoleService $consoleService
     */
    public function __construct(ConsoleService $consoleService)
    {
        $this->consoleService = $consoleService;
    }

    /**
     * @throws DiException
     */
    public function buildWithAllDependencies()
    {
        $this->receiveLogger();
        $this->receiveRedisClient();
        $this->receiveFlashNoticeComponent();
        $this->receiveFormat();
        $this->receiveProtocol();
    }

    /**
     * @throws DiException
     * @throws \LogicException
     */
    private function receiveLogger()
    {
        if (!$this->consoleService->getServicesContainer()->has('logger')) {
            $this->consoleService->getLogger()->critical(
                'Logger not provided in dependency injection',
                ['tags' => ['error']]
            );
            throw new DiException('Logger');
        }

        $logger = $this->consoleService->getServicesContainer()->get('logger');

        if (!($logger instanceof LoggerInterface)) {
            throw new \LogicException();
        }

        $this->consoleService->setLogger($logger);
    }

    /**
     * @throws DiException
     * @throws \LogicException
     */
    private function receiveRedisClient()
    {
        if (!$this->consoleService->getServicesContainer()->has('redis.client')) {
            $this->consoleService->getLogger()->critical(
                'Redis client not provided in dependency injection',
                ['tags' => ['error']]
            );
            throw new DiException('Redis client');
        }

        $redisClient = $this->consoleService->getServicesContainer()->get('redis.client');

        if (!($redisClient instanceof ClientInterface)) {
            throw new \LogicException();
        }

        $this->consoleService->setRedisClient($redisClient);
    }

    /**
     * @throws DiException
     * @throws \LogicException
     */
    private function receiveFlashNoticeComponent()
    {
        if (!$this->consoleService->getServicesContainer()->has('component.flashNotice')) {
            $this->consoleService->getLogger()->critical(
                'component.flashNotice not provided in dependency injection',
                ['tags' => ['error']]
            );
            throw new DiException('FlashNotice');
        }

        $flashNotice = $this->consoleService->getServicesContainer()->get('component.flashNotice');

        if (!($flashNotice instanceof FlashNoticeComponentInterface)) {
            throw new \LogicException();
        }

        $this->consoleService->setFlashNotice($flashNotice);
    }

    /**
     * @throws DiException
     * @throws \LogicException
     */
    private function receiveFormat()
    {
        if (!$this->consoleService->getServicesContainer()->has('format')) {
            $this->consoleService->getLogger()->critical(
                'Format not provided in dependency injection',
                ['tags' => ['error']]
            );
            throw new DiException('Format');
        }

        $format = $this->consoleService->getServicesContainer()->get('format');
        if (!($format instanceof FormatInterface)) {
            $this->consoleService->getLogger()->critical(
                'Format is not instance of FormatInterface',
                ['tags' => ['error']]
            );
            throw new \LogicException();
        }

        $this->consoleService->setFormat($format);
    }

    /**
     * @throws DiException
     * @throws \LogicException
     */
    private function receiveProtocol()
    {
        if (!$this->consoleService->getServicesContainer()->has('protocol')) {
            $this->consoleService->getLogger()->critical(
                'Protocol not provided in dependency injection',
                ['tags' => ['error']]
            );
            throw new DiException('Protocol');
        }

        $protocol = $this->consoleService->getServicesContainer()->get('protocol');
        if (!($protocol instanceof ProtocolInterface)) {
            $this->consoleService->getLogger()->critical(
                'Protocol is not instance of ProtocolInterface',
                ['tags' => ['error']]
            );
            throw new \LogicException();
        }

        $this->consoleService->setProtocol($protocol);
    }
}
