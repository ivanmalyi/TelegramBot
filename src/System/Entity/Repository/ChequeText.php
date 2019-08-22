<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class ChequeText
 * @package System\Entity\Repository
 */
class ChequeText
{
    /**
     * @var int
     */
    private $chequeId;

    /**
     * @var string
     */
    private $text;

    /**
     * @var int
     */
    private $id;

    /**
     * ChequeText constructor.
     * @param int $chequeId
     * @param string $text
     * @param int $id
     */
    public function __construct(int $chequeId, string $text, int $id = 0)
    {
        $this->chequeId = $chequeId;
        $this->text = $text;
        $this->id = $id;
    }
}