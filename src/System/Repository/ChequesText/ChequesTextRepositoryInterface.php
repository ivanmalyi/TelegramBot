<?php

declare(strict_types=1);

namespace System\Repository\ChequesText;


/**
 * Interface ChequeTextRepositoryInterface
 * @package System\Repository\ChequeText
 */
interface ChequesTextRepositoryInterface
{
    /**
     * @param string $text
     * @param int $chequeId
     *
     * @return int
     */
    public function saveChequeText(string $text, int $chequeId): int;
}