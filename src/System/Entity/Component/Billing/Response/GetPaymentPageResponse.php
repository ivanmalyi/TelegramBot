<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;


/**
 * Class GepPaymentPageResponse
 * @package System\Entity\Component\Billing\Response
 */
class GetPaymentPageResponse extends Response
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var UserCard[]
     */
    private $userCards;

    /**
     * GetPaymentPageResponse constructor.
     * @param int $result
     * @param string $time
     * @param string $url
     * @param array $userCards
     */
    public function __construct(int $result, string $time, string $url, array $userCards)
    {
        parent::__construct($result, $time);
        $this->url = $url;
        $this->userCards = $userCards;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
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
     * @return GetPaymentPageResponse
     */
    public static function buildWhenError(int $result): self
    {
        return new self(
            $result,
            date('Y-m-d H:i:s'),
            '',
            []
        );
    }
}