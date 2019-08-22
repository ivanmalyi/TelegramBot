<?php

declare(strict_types=1);

namespace System\Console;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use System\Component\Billing\BillingComponentInterface;
use System\Component\DaemonComponentInterface;
use System\Component\FlashNoticeComponentInterface;
use System\Exception\DiException;
use System\Kernel\Protocol\AnswerBundle;
use System\Kernel\Protocol\CommandLinePacket;
use System\Util\Logging\LoggerReference;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class AbstractConsoleAction
 * @package System\Console
 */
abstract class AbstractCommand implements LoggerReference
{
    use LoggerReferenceTrait;

    /**
     * @var BillingComponentInterface
     */
    private $billingComponent;

    /**
     * @var ContainerBuilder
     */
    private $servicesContainer;

    /**
     * @var FlashNoticeComponentInterface
     */
    private $flashNotice;

    /**
     * @var DaemonComponentInterface
     */
    private $daemonComponent;

    /**
     * @return BillingComponentInterface
     * @throws DiException
     */
    public function getBillingComponent(): BillingComponentInterface
    {
        if (null === $this->billingComponent) {
            throw new DiException('BillingComponent');
        }
        return $this->billingComponent;
    }

    /**
     * @param BillingComponentInterface $billingComponent
     */
    public function setBillingComponent(BillingComponentInterface $billingComponent): void
    {
        $this->billingComponent = $billingComponent;
    }

    /**
     * @return ContainerBuilder
     * @throws DiException
     */
    public function getServicesContainer(): ContainerBuilder
    {
        if (null === $this->servicesContainer) {
            throw new DiException('ServicesContainer');
        }
        return $this->servicesContainer;
    }

    /**
     * @param ContainerBuilder $servicesContainer
     */
    public function setServicesContainer(ContainerBuilder $servicesContainer): void
    {
        $this->servicesContainer = $servicesContainer;
    }

    /**
     * @return FlashNoticeComponentInterface
     * @throws DiException
     */
    public function getFlashNotice()
    {
        if ($this->flashNotice == null) {
            throw new DiException('FlashNoticeComponent');
        }
        return $this->flashNotice;
    }

    /**
     * @param FlashNoticeComponentInterface $flashNotice
     */
    public function setFlashNotice($flashNotice)
    {
        $this->flashNotice = $flashNotice;
    }

    /**
     * @return DaemonComponentInterface
     * @throws DiException
     */
    public function getDaemonComponent(): DaemonComponentInterface
    {
        if ($this->daemonComponent == null) {
            throw new DiException('DaemonComponent');
        }
        return $this->daemonComponent;
    }

    /**
     * @param DaemonComponentInterface $daemonComponent
     */
    public function setDaemonComponent(DaemonComponentInterface $daemonComponent): void
    {
        $this->daemonComponent = $daemonComponent;
    }

    /**
     * @param CommandLinePacket $packet
     * @return AnswerBundle
     */
    abstract public function handle(CommandLinePacket $packet): AnswerBundle;
}
