<?php

declare(strict_types=1);

namespace System\Action;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use System\Component\PayBot\PayBotInterface;
use System\Entity\InternalProtocol\ChatBotId;
use System\Exception\DiException;
use System\Kernel\Protocol\RequestBundle;
use System\Util\Logging\LoggerReferenceTrait;
use System\Util\TelegramBot\BotSettings;

/**
 * Class AbstractController
 * @package System\Controller
 */
abstract class AbstractAction
{
    use LoggerReferenceTrait;

    /**
     * @var PayBotInterface
     */
    private $payBot;

    /**
     * @var ContainerBuilder
     */
    private $servicesContainer;

    /**
     * @var BotSettings
     */
    private $telegramBotSetting;

    /**
     * @return PayBotInterface
     * @throws DiException
     */
    public function getPayBot(): PayBotInterface
    {
        if ($this->payBot === null) {
            throw new DiException('PayBotInterface');
        }
        return $this->payBot;
    }

    /**
     * @param PayBotInterface $payBot
     */
    public function setPayBot(PayBotInterface $payBot): void
    {
        $this->payBot = $payBot;
    }

    /**
     * @return ContainerBuilder
     */
    public function getServicesContainer(): ContainerBuilder
    {
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
     * @return BotSettings
     * @throws DiException
     */
    public function getTelegramBotSetting(): BotSettings
    {
        if ($this->telegramBotSetting === null) {
            throw new DiException('TelegramBotSettings');
        }
        return $this->telegramBotSetting;
    }

    /**
     * @param BotSettings $telegramBotSetting
     */
    public function setTelegramBotSetting(BotSettings $telegramBotSetting): void
    {
        $this->telegramBotSetting = $telegramBotSetting;
    }

    /**
     * @param int $chatBotId
     * @param string $startValue
     * @throws DiException
     */
    public function redirectToBotApp(int $chatBotId, string $startValue = ''): void
    {
        if ($chatBotId === ChatBotId::TELEGRAM) {
            $url = 'Location: https://telegram.me/'.$this->getTelegramBotSetting()->getBotName();
            if ($startValue !== '') {
                $url .= '?start='.$startValue;
            }

            header($url, true);
        }
    }

    /**
     * @param RequestBundle $request
     * @return void
     */
    abstract public function handle(RequestBundle $request);
}