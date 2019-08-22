<?php

declare(strict_types=1);

namespace System\Repository\StagesMessages;

use System\Entity\Component\Billing\LocalizationData;
use System\Entity\Repository\StageMessage;
use System\Exception\EmptyFetchResultException;
use System\Repository\AbstractPdoRepository;

/**
 * Class StagesMessagesRepository
 * @package System\Repository\StagesMessages
 */
class StagesMessagesRepository extends AbstractPdoRepository implements StagesMessagesRepositoryInterface
{
    /**
     * @param int $stage
     * @param int $subStage
     * @param string $localization
     *
     * @return StageMessage
     */
    public function findMessage(int $stage, int $subStage = 0, string $localization = LocalizationData::RU): StageMessage
    {
        $sql = 'select sm.id, sm.stage, sm.sub_stage, sm.localization, sm.message
          from stages_messages sm
            join stages as s on sm.stage=s.id
          where sm.stage=:stage and sm.sub_stage=:subStage and sm.localization=:localization and status = 1';

        try {
            $row = $this->execAssocOne($sql, [
                'stage' => $stage,
                'subStage' => $subStage,
                'localization' => $localization
            ]);
        } catch (EmptyFetchResultException $e) {
            return new StageMessage($stage, $subStage, $localization,'');
        }

        return $this->inflate($row);
    }

    /**
     * @param array $row
     *
     * @return StageMessage
     */
    private function inflate(array $row): StageMessage
    {
        return new StageMessage(
            (int) $row['stage'],
            (int) $row['sub_stage'],
            $row['localization'],
            $row['message'],
            (int) $row['id']
        );
    }
}
