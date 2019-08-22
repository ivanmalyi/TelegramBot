<?php

declare(strict_types=1);

namespace System\Component\Button;


use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\Repository\Button;

/**
 * Interface ButtonComponentInterface
 * @package System\Component\Button
 */
interface ButtonComponentInterface
{
    /**
     * @param int $buttonId
     * @param string $localization
     * @param StageMessageVariables|null $variables
     *
     * @return Button
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findButton(int $buttonId, string $localization, ?StageMessageVariables $variables = null): Button;

    /**
     * @param string $buttonName
     * @param string $buttonType
     *
     * @return int
     */
    public function findStageByButtonName(string $buttonName, string $buttonType): int;

    /**
     * @param string $buttonType
     * @param string $localization
     *
     * @return Button[]
     */
    public function findButtonsByType(string $buttonType, string $localization): array;
}