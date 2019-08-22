<?php

declare(strict_types=1);

namespace System\Kernel\MessageService;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Routing\Exception\NoConfigurationException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use System\Action\AbstractAction;
use System\Entity\Component\FlashNoticeTransport;
use System\Entity\Provider\ActionRoute;
use System\Exception\Protocol\ProtocolException;
use System\Exception\Protocol\UnknownCommandException;
use System\Kernel\BaseSystemService;
use System\Kernel\Protocol\ProtocolPacket;
use System\Kernel\Protocol\RequestBundle;
use System\Kernel\SystemServiceDependenciesTrait;
use \Symfony\Component\Routing\Loader\YamlFileLoader as RoutingYamlFileLoader;

/**
 * Class SystemMessage
 * @package System\Kernel
 */
class MessageService extends BaseSystemService
{
    use SystemServiceDependenciesTrait;

    /**
     * SystemService constructor.
     * @param string $configFileFolder
     * @param string $environment
     */
    public function __construct(string $configFileFolder, string $environment)
    {
        parent::__construct($configFileFolder, $environment);

        $this->actionsFolder = $configFileFolder . '/actions';
        $this->actionLocator = new FileLocator($this->actionsFolder);
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

        $this->makeAction();

        $delta = microtime(true) - $start;
        $this->getLogger()->info(
            'Request exucute time - '.sprintf('%.4f', $delta),
            ["tags" => ["api", "execute_time"]]
        );
    }

    /**
     * Receive all necessary dependencies for kernel
     * @throws \System\Exception\DiException
     */
    private function receiveDependecies()
    {
        $dependencyReceiver = new MessageDependecyReceiver($this);
        $dependencyReceiver->buildWithAllDependencies();
    }

    private function makeAction()
    {
        try {
            $this->makeActionDirectly();
        } catch (ProtocolException $protocolExc) {
            $this->getLogger()->debug('MessageService ProtocolException: '.$protocolExc->getMessage());
        } catch (\PDOException $e) {
            $this->getLogger()->debug('MessageService ProtocolException: '.$e->getMessage());

            $this->getFlashNotice()->sendMessage(
                'PDOException: '.$e->getMessage(),
                FlashNoticeTransport::TELEGRAM
            );

        } catch (NoConfigurationException $e) {
            $this->getLogger()->debug('NoConfigurationException: route not found');
        } catch (ResourceNotFoundException $e) {
            $this->getLogger()->debug('ResourceNotFoundException: '.$e->getMessage());
        } catch (\Throwable $e) {
            $message = 'Exception MessageService: '.$e->getFile().' '.$e->getLine().' '.$e->getMessage();

            $this->getFlashNotice()->sendMessage($message, FlashNoticeTransport::TELEGRAM);
            $this->getLogger()->debug($message);

        }
    }

    /**
     * @throws ProtocolException
     * @throws UnknownCommandException
     * @throws \ReflectionException
     */
    private function makeActionDirectly()
    {
        $packet = $this->getProtocol()->getIncomingPacket();
        $this->logRequest($packet->getData());
        $controllerRoute = $this->getControllerRoute($packet);

        $rows = $this->getFormat()->decode($packet->getData());
        $rows['IsIntegrationTesting'] = $packet->getHeaders()['IS_INTEGRATION_TESTING'];
        $urlParams = $this->prepareUrlParams($packet);

        $requestBundle = new RequestBundle(
            $packet->getData(),
            $packet->getSignature(),
            $rows,
            $urlParams,
            md5(microtime())
        );

        $this->startWithInternalProtocol($requestBundle, $controllerRoute);
    }

    /**
     * @param string $data
     */
    private function logRequest(string $data)
    {
        $this->getLogger()->log('info', "Prepare data", [
                "data" => $data,
                "tags" => ["api", "request_data_prepared"],
                "remote_addr" => $this->getClientIp()
            ]
        );
    }

    /**
     * @return string
     */
    private function getClientIp(): string
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return (string) $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return (string) $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return (string) $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * @param ProtocolPacket $protocolPacket
     * @return ActionRoute
     * @throws UnknownCommandException
     */
    private function getControllerRoute(ProtocolPacket $protocolPacket): ActionRoute
    {
        $fileLocator = new FileLocator($this->actionsFolder);
        $loader = new RoutingYamlFileLoader($fileLocator);
        $routes = $loader->load('../routes.yml');

        $context = new RequestContext('/');
        $matcher = new UrlMatcher($routes, $context);

        $parameters = $matcher->match($protocolPacket->getHeaders()['REQUEST_URI']);
        $controllerArgs = explode('::', $parameters['_controller']);
        if (count($controllerArgs) < 2) {
            $this->getLogger()->debug($parameters['_controller'].': controller\'s method not found');
            throw new UnknownCommandException('Controller\'s method not found');
        }
        $data = json_decode($protocolPacket->getData(), true);
        $data['Command'] = explode('.', $parameters['_route'])[1];
        $protocolPacket->setData(json_encode($data));


        return new ActionRoute($controllerArgs[0], $controllerArgs[1]);
    }

    /**
     * @param ProtocolPacket $protocolPacket
     * @return array
     */
    private function prepareUrlParams(ProtocolPacket $protocolPacket): array
    {
        $urlParams = [];
        if (!isset($protocolPacket->getHeaders()['REQUEST_URI_PARAMS'])) {
            return $urlParams;
        }

        $pairs = explode('&', $protocolPacket->getHeaders()['REQUEST_URI_PARAMS']);
        foreach ($pairs as $pair) {
            $pairExploded = explode('=', $pair);
            if (count($pairExploded) === 2) {
                $urlParams[$pairExploded[0]] = $pairExploded[1];
            }
        }

        return $urlParams;
    }

    /**
     * @param RequestBundle $request
     * @param ActionRoute $actionRoute
     * @throws UnknownCommandException
     * @throws \ReflectionException
     */
    private function startWithInternalProtocol(
        RequestBundle $request,
        ActionRoute $actionRoute
    )
    {
        $this->loadActionConfiguration($actionRoute);

        $diActionKey = $actionRoute->getDiActionKey();
        if (!$this->getServicesContainer()->has($diActionKey)) {
            $this->getLogger()->debug($diActionKey.' not provided in di container');
            throw new UnknownCommandException('Controller not found');
        }

        $action = $this->getDiActionKey($diActionKey);
        if (!($action instanceof AbstractAction)) {
            $this->getLogger()->critical(
                'Wrong configuration! '.$diActionKey.' must be instance of AbstractAction',
                ['tags' => ['error'],'object' => $this]
            );
            throw new \LogicException(
                'Wrong configuration! '.$diActionKey.' must be instance of AbstractAction'
            );
        }
        $action->setServicesContainer($this->getServicesContainer());

        $reflectionMethod = new \ReflectionMethod($action, $actionRoute->getMethod());
        $reflectionMethod->invokeArgs($action, [$request]);
    }

    /**
     * @param ActionRoute $controllerRoute
     * @throws UnknownCommandException
     */
    private function loadActionConfiguration(ActionRoute $controllerRoute): void
    {
        $loader = new YamlFileLoader($this->getServicesContainer(), $this->actionLocator);
        try {
            $loader->load(
                $this->compileDiActionKey($controllerRoute)
            );
        } catch (UnknownCommandException $e) {
            $this->getLogger()->debug($e->getMessage());
            throw $e;
        } catch (\Throwable $e) {
            $this->getLogger()->debug("Not found file for " . $controllerRoute->getDiActionKey());
            throw new UnknownCommandException('Not found file ' . $controllerRoute->getDiActionKey());
        }
    }

    /**
     * @param ActionRoute $actionRoute
     * @return string
     *
     * @throws UnknownCommandException
     */
    private function compileDiActionKey(ActionRoute $actionRoute): string
    {
        $actionKeyParts = explode('.', $actionRoute->getDiActionKey());
        if (count($actionKeyParts) < 2) {
            throw new UnknownCommandException('Not valid actionKey format');
        }

        return $actionKeyParts[1].'Action.yml';
    }

    /**
     * @param string $diControllerKey
     * @return object
     * @throws UnknownCommandException
     */
    private function getDiActionKey(string $diControllerKey)
    {
        try {
            return $this->getServicesContainer()->get($diControllerKey);
        } catch (\Exception $e) {
            $this->getLogger()->critical(
                'Wrong configuration! Class not found for '.$diControllerKey.'.',
                ['tags' => ['error'],'object' => $this]
            );
            throw new UnknownCommandException('Class not found for '.$diControllerKey);
        }
    }
}
