<?php

use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends AbstractContext
{

    /**
     * FeatureContext constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @When Telegram server send a "POST" request that contain:
     * @param PyStringNode $pyStringNode
     *
     * @throws Exception
     */
    public function sendRequest(PyStringNode $pyStringNode)
    {
        $this->post($pyStringNode->getRaw());
    }

    /**
     * @Then Database table :arg1 consist:
     *
     * @param string $arg1
     * @param TableNode $table
     *
     * @throws Exception
     */
    public function databaseTableConsist(string $arg1, TableNode $table)
    {
        $pdo = $this->connectionDB();

        foreach ($table->getHash() as $row) {
            $sql = 'select * from ' . $arg1;
            $sql .= ' where ';
            $params = [];

            foreach ($row as $key => $value) {

                if (!empty($value)) {
                    $params[] = "{$key} = ".$this->filterExpectedValue((string) $value);
                }
            }
            $sql .= implode(' and ', $params);

            $sth = $pdo->query($sql);
            if (!$sth) {
                throw new Exception('Table "'.$arg1.'" not found');
            }

            $result = $sth->fetch(\PDO::FETCH_ASSOC);

            Assert::assertNotEmpty($result, 'Data not found in '.$arg1);
        }
    }

    /**
     * @return PDO
     */
    private function connectionDB(): \PDO
    {
        $dsn = 'mysql:dbname=' . $this->getMysqlDataBase(). ';port=' . $this->getMysqlPort() . ';host=' . $this->getMysqlHost();

        try {
            $PDO = new PDO($dsn, $this->getMysqlUserName(), $this->getMysqlPassword());

            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $PDO->exec("SET NAMES utf8");
            $PDO->exec("SET character set utf8");
            $PDO->exec("SET character_set_connection='utf8'");

            return $PDO;
        } catch (\PDOException $e) {
            echo $e->getMessage() . "\n";
            echo $e->getLine();

            return $PDO = null;
        }
    }
}
