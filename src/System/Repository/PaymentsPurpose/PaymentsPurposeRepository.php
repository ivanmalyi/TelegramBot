<?php

declare(strict_types=1);

namespace System\Repository\PaymentsPurpose;


use System\Entity\Repository\PaymentPurpose;
use System\Repository\AbstractPdoRepository;

/**
 * Class PaymentsPurposeRepository
 * @package System\Repository\PaymentsPurpose
 */
class PaymentsPurposeRepository extends AbstractPdoRepository implements PaymentsPurposeRepositoryInterface
{
    /**
     * @param PaymentPurpose[] $paymentsPurpose
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function savePaymentsPurpose(array $paymentsPurpose): int
    {
        $sql = /**@lang text */
            'insert into payments_purpose (item_id, localization, purpose) values ';
        $placeholders = [];
        foreach ($paymentsPurpose as $key => $paymentPurpose) {
            $sql .= "(:itemId{$key}, :localization{$key}, :purpose{$key}),";
            $placeholders += [
                "itemId{$key}" => $paymentPurpose->getItemId(),
                "localization{$key}" => $paymentPurpose->getLocalization(),
                "purpose{$key}" => $paymentPurpose->getPurpose()
            ];
        }

        return $this->insert(rtrim($sql, ','), $placeholders);
    }

    /**
     * @param int $itemId
     * @param string $localization
     *
     * @return PaymentPurpose
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findPaymentPurpose(int $itemId, string $localization): PaymentPurpose
    {
        $sql = 'select id, item_id, localization, purpose 
                from payments_purpose
                where item_id = :itemId and localization = :localization';

        $row = $this->execAssocOne($sql, ['itemId'=>$itemId, 'localization'=>$localization]);

        return $this->inflate($row);
    }

    /**
     * @param array $row
     *
     * @return PaymentPurpose
     */
    private function inflate(array $row): PaymentPurpose
    {
        return new PaymentPurpose(
            (int)$row['item_id'],
            $row['localization'],
            $row['purpose'],
            (int)$row['id']
        );
    }

    public function clearTable(): void
    {
        $sql = 'truncate table payments_purpose';
        $this->update($sql, []);
    }
}