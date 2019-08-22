<?php

declare(strict_types=1);

namespace System\Entity\Provider;

/**
 * Class ControllerRoute
 * @package System\Entity
 */
class ActionRoute
{
    /**
     * @var string
     */
    private $diControllerKey;

    /**
     * @var string
     */
    private $method;

    /**
     * ControllerRoute constructor.
     * @param string $diControllerKey
     * @param string $method
     */
    public function __construct(string $diControllerKey, string $method)
    {
        $this->diControllerKey = $diControllerKey;
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getDiActionKey(): string
    {
        return $this->diControllerKey;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}