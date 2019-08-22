<?php

declare(strict_types=1);

namespace System\Repository\PaymentSystemsHeadersLocalization;

use System\Entity\Repository\PaymentSystemHeaderLocalization;
use System\Repository\AbstractPdoRepository;

/**
 * Class PaymentSystemsLocalizationRepository
 * @package System\Repository\PaymentSystemsHeadersLocalization
 */
class PaymentSystemsHeadersLocalizationRepository extends AbstractPdoRepository
    implements PaymentSystemsHeadersLocalizationRepositoryInterface
{
    /**
     * @param PaymentSystemHeaderLocalization $paymentSystemLocalization
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function save(PaymentSystemHeaderLocalization $paymentSystemLocalization): int
    {
        $sql = 'insert into payment_systems_headers_localization (payment_system_id, localization, text)
          VALUES (:paymentSystemId, :localization, :text)';

        return $this->insert($sql, [
            'paymentSystemId' => $paymentSystemLocalization->getPaymentSystemId(),
            'localization' => $paymentSystemLocalization->getLocalization(),
            'text' => $paymentSystemLocalization->getText()
        ]);
    }

    /**
     * @param PaymentSystemHeaderLocalization[] $paymentSystemLocalization
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function saveAll(array $paymentSystemLocalization): int
    {
        $sql = /** @lang text */
            'insert into payment_systems_headers_localization (payment_system_id, localization, text)
        values ';

        $params = [];
        $sqlParams = [];
        for ($i=0; $i<count($paymentSystemLocalization); $i++) {
            $sqlParams[] = "(:paymentSystemId$i, :localization$i, :text$i)";
            $params = array_merge($params, [
                'paymentSystemId'.$i => $paymentSystemLocalization[$i]->getPaymentSystemId(),
                'localization'.$i => $paymentSystemLocalization[$i]->getLocalization(),
                'text'.$i => $paymentSystemLocalization[$i]->getText()
            ]);
        }

        return $this->insert($sql.implode(',', $sqlParams), $params);
    }

    /**
     * @return int
     */
    public function deleteAll(): int
    {
        $sql = 'delete from payment_systems_headers_localization where id > 0';

        return $this->update($sql, []);
    }

    /**
     * @param int $paymentSystemId
     * @param string $localization
     *
     * @return PaymentSystemHeaderLocalization
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findPaymentSystemById(int $paymentSystemId, string $localization): PaymentSystemHeaderLocalization
    {
        $sql = 'select pshl.id, pshl.payment_system_id, pshl.localization, pshl.text
                from payment_systems_headers_localization as pshl
                  left join payment_systems as ps on ps.id = pshl.payment_system_id
                where pshl.localization = :localization and ps.id = :paymentSystemId';

        $row = $this->execAssocOne($sql, ['localization' => $localization, 'paymentSystemId' => $paymentSystemId]);

        return $this->inflate($row);
    }

    /**
     * @param array $row
     *
     * @return PaymentSystemHeaderLocalization
     */
    private function inflate(array $row): PaymentSystemHeaderLocalization
    {
        return new PaymentSystemHeaderLocalization(
            (int) $row['payment_system_id'],
            $row['localization'],
            $row['text'],
            (int) $row['id']
        );
    }
}
