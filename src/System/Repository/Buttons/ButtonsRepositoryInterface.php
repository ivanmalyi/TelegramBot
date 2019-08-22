<?php

declare(strict_types=1);

namespace System\Repository\Buttons;


use System\Entity\Repository\Button;

/**
 * Interface ButtonsRepositoryInterface
 * @package System\Repository\Buttons
 */
interface ButtonsRepositoryInterface
{
    /**
     * @param int $buttonId
     * @param string $localization
     *
     * @return Button
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findButton(int $buttonId, string $localization): Button;


    /**
     * @param string $buttonType
     * @param string $localization
     *
     * @return Button[]
     */
    public function findButtonsByType(string $buttonType, string $localization = ''): array;
}