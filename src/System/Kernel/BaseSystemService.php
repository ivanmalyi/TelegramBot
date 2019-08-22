<?php

declare(strict_types=1);

namespace System\Kernel;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use System\Entity\InternalProtocol\ResponseCode;
use System\Exception\PhpException;
use System\Util\Logging\LoggerReference;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class BaseSystemService
 * @package System\Kernel
 */
abstract class BaseSystemService implements RunnableInterface, LoggerReference
{
    use LoggerReferenceTrait;

    /**
     * Configuration file name for variables
     * @var string
     */
    const C_PARAMETERS  = 'options';

    /**
     * Configuration file name for DI
     * @var string
     */
    const C_SERVICES = 'container';

    /**
     * Configuration file name for repositories
     * @var string
     */
    const C_REPOSITORIES = 'repositories';

    /**
     * Configuration file name for components
     * @var string
     */
    const C_COMPONENTS = 'components';

    /**
     * @var string
     */
    private $environment;

    /**
     * @var ContainerBuilder
     */
    private $servicesContainer;

    /**
     * @var FileLocator
     */
    private $mainLocator;

    /**
     * @var string[]
     */
    protected $loadedActionsFiles = [];

    /**
     * BaseSystemService constructor.
     * @param string $configFileFolder
     * @param string $environment
     */
    public function __construct(string $configFileFolder, string $environment)
    {
        $this->setServicesContainer(new ContainerBuilder());
        $this->environment = $environment;
        $this->mainLocator = new FileLocator($configFileFolder);
    }

    /**
     * Return DI container
     *
     * @return ContainerBuilder
     */
    public function getServicesContainer() : ContainerBuilder
    {
        return $this->servicesContainer;
    }

    /**
     * Set DI container
     *
     * @param ContainerBuilder $servicesContainer
     * @return void
     */
    public function setServicesContainer(ContainerBuilder $servicesContainer)
    {
        $this->servicesContainer = $servicesContainer;
    }

    /**
     * Performs execution
     *
     * @return void
     */
    abstract protected function startSafe();

    /**
     * Runs some code
     *
     * @return void
     */
    public function run()
    {
        $start = microtime(true);

        $this->establishEnvironment();

        try {
            $this->startSafe();
            $delta = microtime(true) - $start;
            $this->getLogger()->info(
                sprintf('Request done in %.4f sec', $delta),
                ['object' => $this, 'time' => $delta]
            );
        } catch (\Throwable $t) {
            $message = $this->environment === 'prod' ? '' : $t->getMessage();
            echo json_encode(['ResultCode' => ResponseCode::UNKNOWN_ERROR, 'Message' => $message]);
            $this->getLogger()->critical($t->getMessage(), ['object' => $this, 'exception' => $t, 'tags' =>['error']]);
        }
    }

    /**
     * Internal method for PHP environment
     */
    protected function establishEnvironment()
    {
        if (function_exists('mb_internal_encoding')) {
            mb_internal_encoding('UTF-8');
        }

        date_default_timezone_set('Europe/Kiev');

        error_reporting(E_ALL);
        set_error_handler(
            function ($errorCode, $errorDescription, $errorFile, $errorLine, array $errorContext = []) {
                throw new PhpException($errorCode, $errorDescription, $errorFile, $errorLine, $errorContext);
            }
        );
    }

    /**
     * Load main configuration
     *
     * @return void
     * @throws \Exception
     */
    protected function loadMainConfiguration()
    {
        $loader = new YamlFileLoader($this->getServicesContainer(), $this->mainLocator);

        foreach ($this->getServiceConfiguration() as $file) {
            try {
                $loader->load($file);
            } catch (\InvalidArgumentException $e) {
                $this->getLogger()->debug('Not found config file ' . $file, ['object' => $this]);
            }
        }
    }

    /**
     * Returns list of configuration files, used while application startup
     *
     * @return string[]
     */
    public function getServiceConfiguration() : array
    {
        return [
            // Global settings (under VCS)
            self::C_PARAMETERS . '.yml',
            self::C_SERVICES   . '.yml',
            self::C_REPOSITORIES . '.yml',
            self::C_COMPONENTS . '.yml',

            // Environment specific
            self::C_PARAMETERS . '.' . $this->environment . '.yml',
            self::C_SERVICES   . '.' . $this->environment . '.yml',
        ];
    }
}
