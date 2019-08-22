<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;


class UserCard
{
    /**
     * @var string
     */
    private $card;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $token;

    /**
     * UserCard constructor.
     * @param string $card
     * @param string $url
     * @param string $token
     */
    public function __construct(string $card, string $url = '', string $token = '')
    {
        $this->card = $card;
        $this->url = $url;
        $this->token = $token;
    }


    /**
     * @return string
     */
    public function getCard(): string
    {
        return $this->card;
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
    public function getToken(): string
    {
        return $this->token;
    }
}