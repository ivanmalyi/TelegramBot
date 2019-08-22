<?php

declare(strict_types=1);

namespace System\Repository\PaymentSystems;

use System\Entity\Repository\PaymentSystem;
use System\Repository\AbstractPdoRepository;

/**
 * Class PaymentSystemsRepository
 * @package System\Repository\PaymentSystems
 */
class PaymentSystemsRepository extends AbstractPdoRepository implements PaymentSystemsRepositoryInterface
{
    /**
     * @param PaymentSystem $paymentSystem
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function save(PaymentSystem $paymentSystem): int
    {
        $sql = 'insert into payment_systems (id, name) values (:id, :name)';

        return $this->insert($sql, ['id' => $paymentSystem->getId(), 'name' => $paymentSystem->getName()]);
    }

    /**
     * @param PaymentSystem[] $paymentSystems
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function saveAll(array $paymentSystems): int
    {
        $sql = /** @lang text */
            'insert into payment_systems (id, name)
        values ';

        $params = [];
        $sqlParams = [];
        for ($i=0; $i<count($paymentSystems); $i++) {
            $sqlParams[] = "(:id$i, :name$i)";
            $params = array_merge($params, [
                'id'.$i => $paymentSystems[$i]->getId(),
                'name'.$i => $paymentSystems[$i]->getName()
            ]);
        }

        return $this->insert($sql.implode(',', $sqlParams), $params);
    }

    /**
     * @return int
     */
    public function deleteAll(): int
    {
        $sql = 'delete from payment_systems where id > 0';

        return $this->update($sql, []);
    }
}
