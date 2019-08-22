<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;

use System\Entity\Repository\Commission;

/**
 * Class LoadCommissionResponse
 * @package System\Entity\Component\Billing\Response
 */
class LoadCommissionResponse extends Response
{
    /**
     * @var Commission[]
     */
    private $commissions;

    /**
     * DownloadKeysResponse constructor.
     * @param int $result
     * @param string $time
     */
    public function __construct(int $result, string $time)
    {
        parent::__construct($result, $time);
    }

    /**
     * @return Commission[]
     */
    public function getCommissions(): array
    {
        return $this->commissions;
    }

    /**
     * @param Commission[] $commissions
     */
    public function setCommissions(array $commissions): void
    {
        $this->commissions = $commissions;
    }
}