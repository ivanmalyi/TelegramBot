<?php

declare(strict_types=1);

namespace System\Repository\PaymentsPrintData;

use System\Entity\Repository\PaymentPrintData;
use System\Repository\AbstractPdoRepository;

/**
 * Class PaymentsPrintDataRepository
 * @package System\Repository\PaymentsPrintData
 */
class PaymentsPrintDataRepository extends AbstractPdoRepository implements PaymentsPrintDataRepositoryInterface
{
    /**
     * @param PaymentPrintData $data
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function create(PaymentPrintData $data): int
    {
        $sql = 'insert into payments_print_data (payment_id, text, value, target)
          values (:paymentId, :text, :value, :target)';

        return $this->insert($sql, [
            'paymentId' => $data->getPaymentId(),
            'text' => $data->getText(),
            'value' => $data->getValue(),
            'target' => $data->getTarget()
        ]);
    }
}
