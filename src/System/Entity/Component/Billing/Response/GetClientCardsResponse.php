<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;


class GetClientCardsResponse  extends Response
{
    /**
     * @var UserCard[]
     */
    private $userCards;

    /**
     * GetClientCardsResponse constructor.
     * @param int $result
     * @param string $time
     * @param array $userCards
     */
    public function __construct(int $result, string $time, array $userCards)
    {
        parent::__construct($result, $time);
        $this->userCards = $userCards;
    }

    /**
     * @return UserCard[]
     */
    public function getUserCards(): array
    {
        return $this->userCards;
    }

    /**
     * @param int $result
     * @return GetClientCardsResponse
     */
    public static function buildWhenError(int $result): self
    {
        return new self($result, date('Y-m-d H:i:s'), []);
    }
}