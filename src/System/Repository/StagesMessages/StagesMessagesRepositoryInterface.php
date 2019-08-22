<?php

declare(strict_types=1);

namespace System\Repository\StagesMessages;

use System\Entity\Component\Billing\LocalizationData;
use System\Entity\Repository\StageMessage;

/**
 * Interface StagesMessagesRepositoryInterface
 * @package System\Repository\StagesMessages
 */
interface StagesMessagesRepositoryInterface
{
    /**
     * @param int $stage
     * @param int $subStage
     * @param string $localization
     *
     * @return StageMessage
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findMessage(int $stage, int $subStage = 0, string $localization = LocalizationData::RU): StageMessage;
}
