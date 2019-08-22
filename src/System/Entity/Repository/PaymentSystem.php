<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class PaymentSystem
 * @package System\Entity\Repository
 */
class PaymentSystem
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $id;

    /**
     * PaymentSystem constructor.
     * @param string $name
     * @param int $id
     */
    public function __construct(string $name, int $id = 0)
    {
        $this->name = $name;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
