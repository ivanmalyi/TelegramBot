<?php

declare(strict_types=1);

namespace System\Util\Algorithm;

use System\Exception\Command\CardNotValid;

/**
 * Class LuhnAlgorithm
 * @package System\Util\Algorithm
 */
class LuhnAlgorithm
{
    /**
     * @var string
     */
    private $card;

    /**
     * LuhnAlgorithm constructor.
     * @param string $cardNumber
     */
    public function __construct(string $cardNumber)
    {
        $this->card = $cardNumber;
    }

    /**
     * @return string
     */
    private function getCard(): string
    {
        return $this->card;
    }

    /**
     * @throws CardNotValid
     */
    public function exec(): void
    {
        if (strlen($this->getCard()) !== 16) {
            throw new CardNotValid($this->getCard());
        }

        $sum = 0;
        for($i=0; $i<16; $i++) {
            if($i % 2 == 0) {
                $sum += ($this->getCard()[$i] * 2) > 9 ? $this->getCard()[$i] * 2 - 9 : $this->getCard()[$i] * 2;
            } else {
                $sum += $this->getCard()[$i];
            }

        }

        $lastNumber = $sum%10;
        if ($lastNumber !== 0) {
            throw new CardNotValid($this->getCard());
        }
    }
}
