<?php

declare(strict_types=1);

namespace System\Util\Logging;

/**
 * Class AcquiringProcessor
 * @package System\Util\Logging
 */
class AcquiringProcessor
{
    /**
     * @var string
     */
    private $session;

    /**
     * @var string
     */
    private $login;

    /**
     * BillingProcessor constructor.
     * @param string $login
     */
    public function __construct(string $login = '')
    {
        $this->login = $login;
        $this->session = $this->createSessionGuid();
    }

    /**
     * @param array $record
     * @return array
     */
    public function __invoke(array $record)
    {
        $record['extra']['session'] = $this->session;
        if ($this->login !== '') {
            $record['extra']['login'] = $this->login;
        }

        return $record;
    }

    /**
     * @return string
     */
    private function createSessionGuid() : string
    {
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535),
            mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
}
