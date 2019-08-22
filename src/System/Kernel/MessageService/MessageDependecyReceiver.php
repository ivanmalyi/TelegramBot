<?php

declare(strict_types=1);

namespace System\Kernel\MessageService;

use Predis\ClientInterface;
use Psr\Log\LoggerInterface;
use System\Component\FlashNoticeComponentInterface;
use System\Component\SecurityComponentInterface;
use System\Exception\DiException;
use System\Kernel\Protocol\FormatInterface;
use System\Kernel\Protocol\ProtocolInterface;

/**
 * Class MessageDependecyReceiver
 * @package System\Kernel
 */
class MessageDependecyReceiver
{
    /**
     * @var MessageService
     */
    private $systemService;

    /**
     * SystemDependecyReceiver constructor.
     * @param MessageService $systemService
     */
    public function __construct(MessageService $systemService)
    {
        $this->systemService = $systemService;
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
        $this->receiveSecurityComponent();
        $this->receiveProtocol();
    }

    /**
     * @throws DiException
     * @throws \LogicException
     * @throws \Exception
     */
    private function receiveLogger()
    {
        if (!$this->systemService->getServicesContainer()->has('logger')) {
            $this->systemService->getLogger()->critical(
                'Logger not provided in dependency injection',
                ['tags' => ['error']]
            );
            throw new DiException('Logger');
        }

        $logger = $this->systemService->getServicesContainer()->get('logger');

        if (!($logger instanceof LoggerInterface)) {
            throw new \LogicException();
        }

        $this->systemService->setLogger($logger);
    }

    /**
     * @throws DiException
     * @throws \LogicException
     * @throws \Exception
     */
    private function receiveRedisClient()
    {
        if (!$this->systemService->getServicesContainer()->has('redis.client')) {
            $this->systemService->getLogger()->critical(
                'Redis client not provided in dependency injection',
                ['tags' => ['error']]
            );
            throw new DiException('Redis client');
        }

        $redisClient = $this->systemService->getServicesContainer()->get('redis.client');

        if (!($redisClient instanceof ClientInterface)) {
            throw new \LogicException();
        }

        $this->systemService->setRedisClient($redisClient);
    }

    /**
     * @throws DiException
     * @throws \Exception
     */
    private function receiveFlashNoticeComponent()
    {
        if (!$this->systemService->getServicesContainer()->has('component.flashNotice')) {
            $this->systemService->getLogger()->critical(
                'component.flashNotice not provided in dependency injection',
                ['tags' => ['error']]
            );
            throw new DiException('FlashNotice');
        }

        $flashNotice = $this->systemService->getServicesContainer()->get('component.flashNotice');

        if (!($flashNotice instanceof FlashNoticeComponentInterface)) {
            throw new \LogicException();
        }

        $this->systemService->setFlashNotice($flashNotice);
    }

    /**
     * @throws DiException
     * @throws \LogicException
     * @throws \Exception
     */
    private function receiveFormat()
    {
        if (!$this->systemService->getServicesContainer()->has('format')) {
            $this->systemService->getLogger()->critical(
                'Format not provided in dependency injection',
                ['tags' => ['error']]
            );
            throw new DiException('Format');
        }

        $format = $this->systemService->getServicesContainer()->get('format');
        if (!($format instanceof FormatInterface)) {
            $this->systemService->getLogger()->critical(
                'Format is not instance of FormatInterface',
                ['tags' => ['error']]
            );
            throw new \LogicException();
        }

        $this->systemService->setFormat($format);
    }

    /**
     * @throws DiException
     * @throws \LogicException
     * @throws \Exception
     */
    private function receiveSecurityComponent()
    {
        if (!$this->systemService->getServicesContainer()->has('component.security')) {
            $this->systemService->getLogger()->critical('Security not provided in DI', ['tags' => ['error']]);
            throw new DiException('SecurityComponent');
        }

        $security = $this->systemService->getServicesContainer()->get('component.security');
        if (!($security instanceof SecurityComponentInterface)) {
            $this->systemService->getLogger()->critical(
                'Security is not instance of SecurityComponentInterface',
                ['tags' => ['error']]
            );
            throw new \LogicException();
        }

        $this->systemService->setSecurityComponent($security);
    }

    /**
     * @throws DiException
     * @throws \LogicException
     * @throws \Exception
     */
    private function receiveProtocol()
    {
        if (!$this->systemService->getServicesContainer()->has('protocol')) {
            $this->systemService->getLogger()->critical(
                'Protocol not provided in dependency injection',
                ['tags' => ['error']]
            );
            throw new DiException('Protocol');
        }

        $protocol = $this->systemService->getServicesContainer()->get('protocol');
        if (!($protocol instanceof ProtocolInterface)) {
            $this->systemService->getLogger()->critical(
                'Protocol is not instance of ProtocolInterface',
                ['tags' => ['error']]
            );
            throw new \LogicException();
        }

        $this->systemService->setProtocol($protocol);
    }
}
