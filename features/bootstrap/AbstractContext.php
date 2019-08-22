<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Symfony\Component\Yaml\Yaml;

/**
 * Class AbstractContext
 */
abstract class AbstractContext implements Context
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $mysqlHost;

    /**
     * @var string
     */
    private $mysqlPort;

    /**
     * @var string
     */
    private $mysqlUserName;

    /**
     * @var string
     */
    private $mysqlPassword;

    /**
     * @var string
     */
    private $mysqlDataBase;

    /**
     * @var int
     */
    private $receiverTGChatId;

    /**
     * @var string
     */
    private $receiverTGFirstName;

    /**
     * @var string
     */
    private $receiverTGLastName;

    /**
     * AbstractCommandContext constructor.
     */
    public function __construct()
    {
        $configFiles = ['options.dev.yml'];

        try {
            foreach ($configFiles as $configFile) {
                $parameter = Yaml::parse(file_get_contents(__DIR__ . '/../../config/' . $configFile));
                if ($configFile == 'options.dev.yml') {
                    $this->url = $parameter['parameters']['chatbot.hostname'];
                    $this->mysqlHost = $parameter['parameters']['mysql.host'];
                    $this->mysqlPort = (string)$parameter['parameters']['mysql.port'];
                    $this->mysqlUserName = $parameter['parameters']['mysql.username'];
                    $this->mysqlPassword = (string)$parameter['parameters']['mysql.password'];
                    $this->mysqlDataBase = $parameter['parameters']['mysql.database'];
                    $this->receiverTGChatId = $parameter['parameters']['receiver.telegram_chat_id'];
                    $this->receiverTGFirstName = $parameter['parameters']['receiver.telegram_first_name'];
                    $this->receiverTGLastName = $parameter['parameters']['receiver.telegram_last_name'];
                }
            }
        } catch (\Exception $e) {
            print_r($e->getMessage() . "\n" . $e->getLine());
        }
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getMysqlHost(): string
    {
        return $this->mysqlHost;
    }

    /**
     * @return string
     */
    public function getMysqlPort(): string
    {
        return $this->mysqlPort;
    }

    /**
     * @return string
     */
    public function getMysqlUserName(): string
    {
        return $this->mysqlUserName;
    }

    /**
     * @return string
     */
    public function getMysqlPassword(): string
    {
        return $this->mysqlPassword;
    }

    /**
     * @return string
     */
    public function getMysqlDataBase(): string
    {
        return $this->mysqlDataBase;
    }

    /**
     * @return int
     */
    public function getReceiverTGChatId(): int
    {
        return $this->receiverTGChatId;
    }

    /**
     * @return string
     */
    public function getReceiverTGFirstName(): string
    {
        return $this->receiverTGFirstName;
    }

    /**
     * @return string
     */
    public function getReceiverTGLastName(): string
    {
        return $this->receiverTGLastName;
    }

    /**
     * @param string $data
     *
     * @throws Exception
     */
    protected function post(string $data): void
    {
        try {
            $stream = curl_init();

            $options = [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_URL => $this->getUrl() . '/telegram',
                CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'is-integration-testing: true'],
                CURLOPT_POSTFIELDS => $this->filterExpectedValue($data),
                CURLOPT_HEADER => true
            ];

            curl_setopt_array($stream, $options);
            $postResponse = curl_exec($stream);
        } catch (Exception $e) {
            throw new Exception(curl_error($stream));
        }
        curl_close($stream);
    }

    protected function filterExpectedValue(string $value): string
    {
        $data = str_replace('{ReceiverTGChatId}', $this->getReceiverTGChatId(), $value);
        $data = str_replace('{ReceiverTGFirstName}', $this->getReceiverTGFirstName(), $data);
        $data = str_replace('{ReceiverTGLastName}', $this->getReceiverTGLastName(), $data);
        return $data;
    }
}