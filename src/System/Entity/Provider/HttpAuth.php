<?php

declare(strict_types=1);

namespace System\Entity\Provider;

/**
 * Class HttpAuth
 * @package System\Entity\Provider
 */
class HttpAuth
{
    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $password;

    /**
     * HttpAuth constructor.
     * @param string $login
     * @param string $password
     */
    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getLogin() : string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }
}
