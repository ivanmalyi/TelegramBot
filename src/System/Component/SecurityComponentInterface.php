<?php

declare(strict_types=1);

namespace System\Component;

use System\Entity\PairKeys;

interface SecurityComponentInterface
{
    /**
     * @param string $string
     * @param string $privateKey
     * @return string
     */
    public function sign(string $string, string $privateKey) : string;

    /**
     * @param string $signature
     * @param string $string
     * @param string $publicKey
     */
    public function verify(string $signature, string $string, string $publicKey);

    /**
     * @return PairKeys
     */
    public function generatePairKeys();
}
