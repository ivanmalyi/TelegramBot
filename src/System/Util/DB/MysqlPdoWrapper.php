<?php

declare(strict_types=1);

namespace System\Util\DB;

/**
 * Class MysqlPdoWrapper
 * @package System\Util\DB
 */
class MysqlPdoWrapper extends \PDO
{
    /**
     * MysqlPdoWrapper constructor.
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string $password
     * @param string $database
     */
    public function __construct(string $host, int $port, string $username, string $password, string $database)
    {
        $dsn = 'mysql:host=' . $host. ';dbname=' . $database . ';port=' . $port . ';charset=utf8';
        parent::__construct($dsn, $username, $password);

        $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->exec("SET NAMES utf8");
        $this->exec("SET character set utf8");
        $this->exec("SET character_set_connection='utf8'");
    }
}
