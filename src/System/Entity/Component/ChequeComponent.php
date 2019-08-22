<?php

declare(strict_types=1);

namespace System\Entity\Component;

/**
 * Class ChequeComponent
 * @package System\Entity\Component
 */
/**
 * Class ChequeComponent
 * @package System\Entity\Component
 */
class ChequeComponent
{
    /**
     * @var string
     */
    private $chequeText;

    /**
     * @var string
     */
    private $chequeName;

    /**
     * @var string
     */
    private $chequeUrl;

    /**
     * ChequeComponent constructor.
     * @param string $chequeText
     * @param string $chequeName
     * @param string $chequeUrl
     */
    public function __construct(string $chequeText, string $chequeName, string $chequeUrl)
    {
        $this->chequeText = $chequeText;
        $this->chequeName = $chequeName;
        $this->chequeUrl = $chequeUrl;
    }

    /**
     * @return string
     */
    public function getChequeText(): string
    {
        return $this->chequeText;
    }

    /**
     * @return string
     */
    public function getChequeName(): string
    {
        return $this->chequeName;
    }

    /**
     * @return string
     */
    public function getChequeUrl(): string
    {
        return $this->chequeUrl;
    }
}