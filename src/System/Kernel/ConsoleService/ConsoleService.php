<?php

declare(strict_types=1);

namespace System\Kernel\ConsoleService;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use System\Console\AbstractCommand;
use System\Entity\Component\FlashNoticeTransport;
use System\Entity\InternalProtocol\ResponseCode;
use System\Exception\Protocol\ProtocolException;
use System\Exception\Protocol\UnknownCommandException;
use System\Kernel\BaseSystemService;
use System\Kernel\Protocol\AnswerBundle;
use System\Kernel\Protocol\CommandLinePacket;
use System\Kernel\Protocol\ProtocolPacket;
use System\Kernel\SystemServiceDependenciesTrait;

class ConsoleService extends BaseSystemService
{
    use SystemServiceDependenciesTrait;

    /**
     * SystemService constructor.
     * @param string $configFileFolder
     * @param string $environment
     * @param array $CLParams
     */
    public function __construct(string $configFileFolder, string $environment, array $CLParams)
    {
        parent::__construct($configFileFolder, $environment);

        $this->actionsFolder = [$configFileFolder.'/commands/'];
        $this->actionLocator = new FileLocator($this->actionsFolder);
        $this->argv = $CLParams;
    }

    /**
     * Performs execution
     *
     * @return void
     * @throws \System\Exception\DiException
     * @throws \Exception
     */
    protected function startSafe()
    {
        $start = microtime(true);

        $this->loadMainConfiguration();
        $this->receiveDependecies();

        $answerBundle = $this->makeAction();

        $delta = microtime(true) - $start;
        $this->getLogger()->info(
            'ConsoleService request exucute time - '.sprintf('%.4f', $delta),
            ["tags" => ["api", "console", "execute_time"]]
        );

        $this->sendAnswer($answerBundle);
    }

    /**
     * Receive all necessary dependencies for kernel
     * @throws \System\Exception\DiException
     */
    private function receiveDependecies()
    {
        $dependencyReceiver = new ConsoleDependencyReceiver($this);
        $dependencyReceiver->buildWithAllDependencies();
    }

    /**
     * @return AnswerBundle
     */
    private function makeAction(): AnswerBundle
    {
        try {
            return $this->makeActionDirectly();
        } catch (ProtocolException $protocolExc) {
            $params = [
                'Result' => $protocolExc->getCode(),
                'Message' => $protocolExc->getMessage(),
                'Time' => date('Y-m-d H:i:s')
            ];
            return new AnswerBundle($params);
        } catch (\PDOException $e) {
            $this->getFlashNotice()->sendMessage(
                'PDOException: '.$e->getMessage(),
                FlashNoticeTransport::TELEGRAM
            );

            $params = [
                'Result' => ResponseCode::DATABASE_ERROR,
                'Message' => 'DataBase error',
                'Time' => date('Y-m-d H:i:s')
            ];
            return new AnswerBundle($params);
        } catch (\Throwable $e) {
            $message = 'Exception SystemService: '.$e->getFile().' '.$e->getLine().' '.$e->getMessage();
            $this->getFlashNotice()->sendMessage($message, FlashNoticeTransport::TELEGRAM);

            $params = [
                'Result' => ResponseCode::UNKNOWN_ERROR,
                'Message' => "Unknown error",
                'Time' => date('Y-m-d H:i:s')
            ];
            return new AnswerBundle($params);
        }
    }

    /**
     * @return AnswerBundle
     *
     * @throws ProtocolException
     * @throws UnknownCommandException
     */
    private function makeActionDirectly(): AnswerBundle
    {
        $packet = $this->getCommandLinePacket();
        $this->logRequest((string) $packet);

        $this->loadCommandConfiguration($packet->getCommand());
        return $this->startWithInternalProtocol($packet);
    }

    /**
     * @return CommandLinePacket
     * @throws UnknownCommandException
     */
    public function getCommandLinePacket(): CommandLinePacket
    {
        if (count($this->argv) < 3) {
            throw new UnknownCommandException('Command argument not found');
        }

        $command = $this->argv[2];
        $parameters = array_slice($this->argv, 3);

        return new CommandLinePacket($command, $parameters);
    }

    /**
     * @param CommandLinePacket $packet
     * @return AnswerBundle $answer
     *
     * @throws UnknownCommandException
     */
    private function startWithInternalProtocol(CommandLinePacket $packet): AnswerBundle
    {
        $diActionKey = 'console.' . strtolower($packet->getCommand());
        if (!$this->getServicesContainer()->has($diActionKey)) {
            $this->getLogger()->debug($diActionKey . ' not provided in di container');
            throw new UnknownCommandException('ConsoleService command ' . $packet->getCommand() . ' not found');
        }

        $consoleAction = $this->getDiConsoleActionKey($diActionKey);
        if (!($consoleAction instanceof AbstractCommand)) {
            $this->getLogger()->critical(
                'Wrong configuration! ' . $diActionKey . ' must be instance of AbstractCommand',
                ['tags' => ['error'],'object' => $this]
            );
            throw new \LogicException(
                'Wrong configuration! ' . $diActionKey . ' must be instance of AbstractCommand'
            );
        }
        $consoleAction->setServicesContainer($this->getServicesContainer());

        return $consoleAction->handle($packet);
    }

    /**
     * @param string $diConsoleActionKey
     * @return object
     * @throws UnknownCommandException
     */
    private function getDiConsoleActionKey(string $diConsoleActionKey)
    {
        try {
            return $this->getServicesContainer()->get($diConsoleActionKey);
        } catch (\Exception $e) {
            $this->getLogger()->critical(
                'Wrong configuration! ConsoleService Class not found for '.$diConsoleActionKey.'.',
                ['tags' => ['error'],'object' => $this]
            );
            throw new UnknownCommandException('ConsoleService Class not found for '.$diConsoleActionKey);
        }
    }

    /**
     * @param AnswerBundle $answerBundle
     */
    private function sendAnswer(AnswerBundle $answerBundle)
    {
        $responseBody = $this->getFormat()->encode($answerBundle);

        $this->getLogger()->debug(
            'encode response',
            ['response' => $responseBody, 'tags' => ['api', 'console', 'response']]
        );

        $this->getProtocol()->sendResponse(new ProtocolPacket($responseBody, '', ['Content-Type: json']));
    }

    /**
     * @param string $actionName
     * @throws ProtocolException
     */
    private function loadCommandConfiguration(string $actionName)
    {
        $loader = new YamlFileLoader($this->getServicesContainer(), $this->actionLocator);
        try {
            $consoleActionFile = lcfirst($actionName) . '.yml';
            $loader->load($consoleActionFile);
        } catch (\Exception $e) {
            $this->getLogger()->debug('Not found action file for ' . $actionName);
            throw new UnknownCommandException('Not found action for ' . $actionName);
        }
    }

    /**
     * @param string $data
     */
    private function logRequest(string $data)
    {
        $this->getLogger()->log('info', "CommandLine packet", [
                "data" => $data,
                "tags" => ["api", "console", "request_packet"]
            ]
        );
    }
}
