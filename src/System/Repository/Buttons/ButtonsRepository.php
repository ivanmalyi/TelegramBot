<?php

declare(strict_types=1);

namespace System\Repository\Buttons;


use System\Entity\Repository\Button;
use System\Repository\AbstractPdoRepository;

/**
 * Class ButtonsRepository
 * @package System\Repository\Buttons
 */
class ButtonsRepository extends AbstractPdoRepository implements ButtonsRepositoryInterface
{
    /**
     * @param int $buttonId
     * @param string $localization
     *
     * @return Button
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findButton(int $buttonId, string $localization): Button
    {
        $sql = 'select b.callback_action, b.value, bl.name, b.button_type, b.id
                from buttons as b
                left join buttons_localization as bl on bl.button_id = b.id
                where b.id = :buttonId and localization = :localization';

        $row = $this->execAssocOne($sql, ['buttonId'=>$buttonId, 'localization'=>$localization]);

        return $this->inflate($row);
    }

    /**
     * @param array $row
     *
     * @return Button
     */
    private function inflate(array $row): Button
    {
        return new Button(
            $row['callback_action'],
            $row['name'],
            $row['value'],
            $row['button_type'],
            (int)$row['id']
        );
    }

    /**
     * @param string $buttonType
     * @param string $localization
     *
     * @return Button[]
     */
    public function findButtonsByType(string $buttonType, string $localization = ''): array
    {
        $sql = 'select b.callback_action, b.value, bl.name, b.button_type, b.id
                from buttons as b
                left join buttons_localization as bl on bl.button_id = b.id
                where b.button_type = :buttonType';

        $placeholders = ['buttonType' => $buttonType];

        if (!empty($localization)) {
            $sql .= ' and bl.localization = :localization';
            $placeholders['localization'] = $localization;
        }

        $rows = $this->execAssoc($sql, $placeholders);

        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->inflate($row);
        }

        return $result;
    }
}