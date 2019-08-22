<?php

declare(strict_types=1);

namespace System\Kernel;

use Predis\ClientInterface;
use Symfony\Component\Config\FileLocator;
use System\Component\FlashNoticeComponentInterface;
use System\Component\SecurityComponentInterface;
use System\Kernel\Protocol\FormatInterface;
use System\Kernel\Protocol\ProtocolInterface;

/**
 * Class SystemServiceDependenciesTrait
 * @package System\Kernel
 */
trait SystemServiceDependenciesTrait
{
    /**
     * @var FileLocator
     */
    private $actionLocator;

    /**
     * @var string
     */
    private $actionsFolder;

    /**
     * @var ClientInterface
     */
    private $redisClient;

    /**
     * @var FlashNoticeComponentInterface
     */
    private $flashNotice;

    /**
     * @var FormatInterface
     */
    private $format;

    /**
     * @var SecurityComponentInterface
     */
    private $securityComponent;

    /**
     * @var ProtocolInterface
     */
    private $protocol;

    /**
     * @var array
     */
    private $argv;

    /**
     * @var ProtocolInterface
     */
    private $getProtocol;

    /**
     * @return ClientInterface
     */
    public function getRedisClient(): ClientInterface
    {
        return $this->redisClient;
    }

    /**
     * @param ClientInterface $redisClient
     */
    public function setRedisClient(ClientInterface $redisClient)
    {
        $this->redisClient = $redisClient;
    }

    /**
     * @return FlashNoticeComponentInterface
     */
    public function getFlashNotice(): FlashNoticeComponentInterface
    {
        return $this->flashNotice;
    }

    /**
     * @param FlashNoticeComponentInterface $flashNotice
     */
    public function setFlashNotice(FlashNoticeComponentInterface $flashNotice)
    {
        $this->flashNotice = $flashNotice;
    }

    /**
     * @return FormatInterface
     */
    public function getFormat(): FormatInterface
    {
        return $this->format;
    }

    /**
     * @param FormatInterface $format
     */
    public function setFormat(FormatInterface $format)
    {
        $this->format = $format;
    }

    /**
     * @return SecurityComponentInterface
     */
    public function getSecurityComponent(): SecurityComponentInterface
    {
        return $this->securityComponent;
    }

    /**
     * @param SecurityComponentInterface $securityComponent
     */
    public function setSecurityComponent(SecurityComponentInterface $securityComponent)
    {
        $this->securityComponent = $securityComponent;
    }

    /**
     * @return ProtocolInterface
     */
    public function getProtocol(): ProtocolInterface
    {
        return $this->protocol;
    }

    /**
     * @param ProtocolInterface $protocol
     */
    public function setProtocol(ProtocolInterface $protocol)
    {
        $this->protocol = $protocol;
    }

    /**
     * @return ProtocolInterface
     */
    public function getGetProtocol(): ProtocolInterface
    {
        return $this->getProtocol;
    }

    /**
     * @param ProtocolInterface $getProtocol
     */
    public function setGetProtocol(ProtocolInterface $getProtocol): void
    {
        $this->getProtocol = $getProtocol;
    }
}
