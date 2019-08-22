<?php

declare(strict_types=1);

namespace System\Repository\RecipientsTemplate;

use System\Entity\Repository\RecipientForCheque;
use System\Entity\Repository\RecipientTemplate;
use System\Repository\AbstractPdoRepository;

/**
 * Class RecipientsTemplateRepository
 * @package System\Repository\RecipientsTemplate
 */
class RecipientsTemplateRepository extends AbstractPdoRepository implements RecipientsTemplateRepositoryInterface
{
    /**
     * @param RecipientTemplate $recipientTemplate
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function save(RecipientTemplate $recipientTemplate): int
    {
        $sql = 'insert into recipients_template (template_id, localization, name)
          VALUES (:templateId, :localization, :name)';

        return $this->insert($sql, [
            'templateId' => $recipientTemplate->getTemplateId(),
            'localization' => $recipientTemplate->getLocalization(),
            'name' => $recipientTemplate->getName()
        ]);
    }

    /**
     * @return int
     */
    public function deleteAll(): int
    {
        $sql = 'delete from recipients_template where id>0';

        return $this->update($sql, []);
    }

    /**
     * @param int $itemId
     * @param string $localization
     *
     * @return RecipientForCheque
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findByItemId(int $itemId, string $localization): RecipientForCheque
    {
        $sql = 'select r.template_id, r.company_name, r.recipient_code, r.bank_name, r.bank_code, r.checking_account, rt.name 
                from recipients_template as rt
                left join recipients as r on r.template_id = rt.template_id
                where r.item_id = :itemId and rt.localization = :localization';

        $row = $this->execAssocOne($sql, ['itemId'=>$itemId, 'localization'=>$localization]);

        return $this->inflate($row);
    }

    /**
     * @param array $row
     *
     * @return RecipientForCheque
     */
    private function inflate(array $row): RecipientForCheque
    {
        return new RecipientForCheque(
            (int)$row['template_id'],
            $row['company_name'],
            $row['recipient_code'],
            $row['bank_name'],
            $row['bank_code'],
            $row['checking_account'],
            $row['name']
        );
    }
}
