<?php

declare(strict_types=1);

namespace System\Kernel\Protocol;

use Symfony\Component\DependencyInjection\Exception\OutOfBoundsException;
use System\Exception\Protocol\UnknownCommandException;
use System\Util\ConverterClass\ToStringTrait;

/**
 * Class RequestBundle
 * @package System\Kernel\Protocol
 */
class RequestBundle
{
    use ToStringTrait;
    
    const COMMAND_KEY = 'Command';

    /**
     * @var string
     */
    private $request;

    /**
     * @var string
     */
    private $signature;

    /**
     * @var array
     */
    private $params;

    /**
     * @var array
     */
    private $urlParams;

    /**
     * @var string
     */
    private $sessionId;

    /**
     * RequestBundle constructor.
     * @param string $request
     * @param string $signature
     * @param array $params
     * @param array $urlParams
     * @param string $sessionId
     * @throws UnknownCommandException
     */
    public function __construct(
        string $request,
        string $signature,
        array $params,
        array $urlParams,
        string $sessionId
    ) {
        if (!isset($params[self::COMMAND_KEY])) {
            throw new UnknownCommandException('Request must contain the "'. self::COMMAND_KEY . '" key');
        }

        $this->request = $request;
        $this->signature = $signature;
        $this->params = $params;
        $this->urlParams = $urlParams;
        $this->sessionId = $sessionId;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getRequest() : string
    {
        return $this->request;
    }

    /**
     * @return string
     */
    public function getSignature() : string
    {
        return $this->signature;
    }

    /**
     * @return string
     */
    public function getCommand() : string
    {
        return $this->params[self::COMMAND_KEY];
    }

    /**
     * @return array
     */
    public function getParams() : array
    {
        return $this->params;
    }

    /**
     * @param $key
     * @return int
     * @throws OutOfBoundsException
     */
    public function getParamInt($key) : int
    {
        if (!array_key_exists($key, $this->params)) {
            throw new OutOfBoundsException('Array does not have key '. $key);
        }
        return (int)$this->params[$key];
    }

    /**
     * @param $key
     * @return string
     * @throws OutOfBoundsException
     */
    public function getParamString($key) : string
    {
        if (!array_key_exists($key, $this->params)) {
            throw new OutOfBoundsException('Array does not have key '. $key);
        }
        return (string)$this->params[$key];
    }

    /**
     * @param $key
     * @return float
     * @throws OutOfBoundsException
     */
    public function getParamFloat($key) : float
    {
        if (!array_key_exists($key, $this->params)) {
            throw new OutOfBoundsException('Array does not have key '. $key);
        }
        return (float)$this->params[$key];
    }

    /**
     * @return string
     */
    public function getSessionId() : string
    {
        return $this->sessionId;
    }

    /**
     * @return array
     */
    public function getUrlParams(): array
    {
        return $this->urlParams;
    }
}
