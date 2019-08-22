<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;

/**
 * Class Response
 * @package System\Entity\Component\Billing\Response
 */
class Response
{
    /**
     * @var int
     */
    private $result;

    /**
     * @var string
     */
    private $time;

    /**
     * Response constructor.
     * @param int $result
     * @param string $time
     */
    public function __construct(int $result, string $time)
    {
        $this->result = $result;
        $this->time = $time;
    }

    /**
     * @return int
     */
    public function getResult(): int
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }
}
