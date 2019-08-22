<?php

declare(strict_types=1);

namespace System\Repository\Recipients;

use System\Entity\Repository\Recipient;
use System\Repository\AbstractPdoRepository;

/**
 * Class RecipientsRepository
 * @package System\Repository\Recipients
 */
class RecipientsRepository extends AbstractPdoRepository implements RecipientsRepositoryInterface
{
    /**
     * @param Recipient[] $recipients
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function saveAll(array $recipients): int
    {
        $sql = /** @lang text */
            'insert into recipients (item_id, template_id, company_name, recipient_code,
          bank_name, bank_code, checking_account)
        values ';

        $params = [];
        $sqlParams = [];
        for ($i=0; $i<count($recipients); $i++) {
            $sqlParams[] = "(:itemId$i, :templateId$i, :companyName$i, :recipientCode$i, :bankName$i, :bankCode$i, :checkingAccount$i)";
            $params = array_merge($params, [
                'itemId'.$i => $recipients[$i]->getItemId(),
                'templateId'.$i => $recipients[$i]->getTemplateId(),
                'companyName'.$i => $recipients[$i]->getCompanyName(),
                'recipientCode'.$i => $recipients[$i]->getRecipientCode(),
                'bankName'.$i => $recipients[$i]->getBankName(),
                'bankCode'.$i => $recipients[$i]->getBankCode(),
                'checkingAccount'.$i => $recipients[$i]->getCheckingAccount()
            ]);
        }

        return $this->insert($sql.implode(',', $sqlParams), $params);
    }

    /**
     * @return int
     */
    public function deleteAll(): int
    {
        $sql = 'delete from recipients where id>0';

        return $this->update($sql, []);
    }
}
