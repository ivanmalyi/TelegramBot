<?php

declare(strict_types=1);

namespace System\Console\Command\LoadCommission;

use System\Exception\DiException;
use System\Repository\Commissions\CommissionsRepositoryInterface;

/**
 * Trait LoadCommissionCommandDependenciesTrait
 * @package System\Console\Command\LoadCommission
 */
trait LoadCommissionCommandDependenciesTrait
{
    /**
     * @var CommissionsRepositoryInterface
     */
    private $commissionsRepository;

    /**
     * @return CommissionsRepositoryInterface
     * @throws DiException
     */
    public function getCommissionsRepository(): CommissionsRepositoryInterface
    {
        if (null === $this->commissionsRepository) {
            throw new DiException('CommissionsRepository');
        }

        return $this->commissionsRepository;
    }

    /**
     * @param CommissionsRepositoryInterface $commissionsRepository
     */
    public function setCommissionsRepository(CommissionsRepositoryInterface $commissionsRepository): void
    {
        $this->commissionsRepository = $commissionsRepository;
    }
}
