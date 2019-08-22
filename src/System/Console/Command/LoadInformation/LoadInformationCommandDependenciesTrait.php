<?php

declare(strict_types=1);

namespace System\Console\Command\LoadInformation;

use System\Exception\DiException;
use System\Repository\PointsInfo\PointsInfoRepositoryInterface;


/**
 * Trait LoadInformationCommandDependenciesTrait
 * @package System\Console\Command\LoadInformation
 */
trait LoadInformationCommandDependenciesTrait
{
    /**
     * @var PointsInfoRepositoryInterface
     */
    private $pointsInfoRepository;

    /**
     * @return PointsInfoRepositoryInterface
     * @throws DiException
     */
    public function getPointsInfoRepository(): PointsInfoRepositoryInterface
    {
        if (null === $this->pointsInfoRepository) {
            throw new DiException('PointsInfoRepository');
        }
        return $this->pointsInfoRepository;
    }

    /**
     * @param PointsInfoRepositoryInterface $pointsInfoRepository
     */
    public function setPointsInfoRepository(PointsInfoRepositoryInterface $pointsInfoRepository): void
    {
        $this->pointsInfoRepository = $pointsInfoRepository;
    }
}