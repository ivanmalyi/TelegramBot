<?php

declare(strict_types=1);

namespace System\Repository;

use Monolog\Logger;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Util\Logging\LoggerReference;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class AbstractPdoRepository
 * @package System\Repository
 */
abstract class AbstractPdoRepository implements LoggerReference
{
    use LoggerReferenceTrait;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * Threshold query time value (in milliseconds)
     *
     * @var int
     */
    private $executeWarningThreshold = 50;

    /**
     * @return \PDO
     * @throws DiException
     */
    public function getPdo() : \PDO
    {
        if ($this->pdo === null) {
            throw new DiException('Pdo');
        }
        return $this->pdo;
    }

    /**
     * @param \PDO $pdo
     */
    public function setPdo(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $sql
     * @param array $placeholders
     * @param bool $log
     * @return array
     */
    protected function execAssoc(string $sql, array $placeholders, bool $log = true) : array
    {
        $statement = $this->exec($sql, $placeholders, $log);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param string $sql
     * @param array $placeholders
     * @param bool $log
     * @return array
     * @throws EmptyFetchResultException
     */
    protected function execAssocOne(string $sql, array $placeholders, bool $log = true) : array
    {
        $rows = $this->execAssoc($sql, $placeholders, $log);
        if (count($rows) === 1) {
            return $rows[0];
        } elseif (count($rows) === 0) {
            throw new EmptyFetchResultException;
        } else {
            throw new \LogicException('Find more than 1 record');
        }
    }

    /**
     * @param string $sql
     * @param array $placeholders
     * @param bool $log
     * @return int
     */
    protected function update(string $sql, array $placeholders, bool $log = true) : int
    {
        $statement = $this->exec($sql, $placeholders, $log);
        return $statement->rowCount();
    }

    /**
     * @param string $sql
     * @param array $placeholders
     * @param bool $log
     * @return int
     * @throws DiException
     */
    protected function insert(string $sql, array $placeholders, bool $log = true) : int
    {
        $this->exec($sql, $placeholders, $log);
        return (int)$this->getPdo()->lastInsertId();
    }

    /**
     * @param string $sql
     * @param array $placeholders
     * @param bool $log
     * @return \PDOStatement
     */
    private function exec(string $sql, array $placeholders, bool $log = true) : \PDOStatement
    {
        try {
            $sth = $this->getPdo()->prepare($sql);
            $this->bindParams($sth, $placeholders);
            $start = microtime(true);
            $sth->execute();
            $delta = microtime(true) - $start;
            $level = $delta > $this->executeWarningThreshold ? Logger::DEBUG : Logger::WARNING;
            if ($log) {

                $this->getLogger()->log(
                    $level,
                    sprintf('Statement done in %.4f ms', $delta),
                    [
                        'tags' => ['query'],
                        'sql' => $sql,
                        'params' => json_encode($placeholders),
                        'time' => $delta,
                        'count' => $sth->rowCount()
                    ]
                );
            }
            return $sth;
        } catch (\PDOException $e) {
            $this->getLogger()->emergency(
                'SQL error',
                [
                    'tags' => ['query'],
                    'sql' => $sql,
                    'params' => json_encode($placeholders),
                    'message' => $e->getMessage()
                ]
            );
            
            throw $e;
        }
    }

    /**
     * @param \PDOStatement $statement
     * @param array $placeholders
     */
    private function bindParams(\PDOStatement $statement, array $placeholders)
    {
        foreach ($placeholders as $key => $value) {
            $statement->bindParam(':' . $key, $placeholders[$key], $this->determinateType($placeholders[$key]));
        }
    }

    /**
     * @param mixed $value
     * @return int
     */
    private function determinateType($value)
    {
        switch (gettype($value)) {
            case 'integer':
            case 'float':
            case 'double':
                return \PDO::PARAM_INT;
                break;
            case 'boolean':
                return \PDO::PARAM_BOOL;
            default:
                return \PDO::PARAM_STR;
        }
    }
}
