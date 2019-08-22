<?php

declare(strict_types=1);

namespace System\Repository\ChequesCallbackUrls;

use System\Entity\Repository\ChequeCallbackUrl;
use System\Exception\EmptyFetchResultException;
use System\Repository\AbstractPdoRepository;

/**
 * Class ChequesCallbackUrlsRepository
 * @package System\Repository\ChequesCallbackUrls
 */
class ChequesCallbackUrlsRepository extends AbstractPdoRepository implements ChequesCallbackUrlsRepositoryInterface
{
    /**
     * @param ChequeCallbackUrl $chequeCallbackUrl
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function create(ChequeCallbackUrl $chequeCallbackUrl): int
    {
        $sql = 'insert into cheques_callback_urls (guid, status, cheque_id, callback_url_id, created_at, updated_at)
          VALUES (:guid, :status, :chequeId, :callbackUrlId, :createdAt, :updatedAt)';

        return $this->insert($sql, [
            'guid' => $chequeCallbackUrl->getGuid(),
            'status' => $chequeCallbackUrl->getStatus(),
            'chequeId' => $chequeCallbackUrl->getChequeId(),
            'callbackUrlId' => $chequeCallbackUrl->getCallbackUrlId(),
            'createdAt' => $chequeCallbackUrl->getCreatedAt(),
            'updatedAt' => $chequeCallbackUrl->getUpdatedAt()
        ]);
    }

    /**
     * @param array $row
     * @return ChequeCallbackUrl
     */
    private function inflate(array $row): ChequeCallbackUrl
    {
        return new ChequeCallbackUrl(
            $row['guid'],
            (int) $row['status'],
            (int) $row['cheque_id'],
            (int) $row['callback_url_id'],
            $row['created_at'],
            $row['updated_at'],
            (int) $row['id']
        );
    }

    /**
     * @param string $guid
     *
     * @return ChequeCallbackUrl
     *
     * @throws EmptyFetchResultException
     */
    public function findByGuid(string $guid): ChequeCallbackUrl
    {
        $sql = 'select id, guid, status, cheque_id, callback_url_id, created_at, updated_at
          from cheques_callback_urls
          where guid=:guid';

        $row = $this->execAssocOne($sql, [
            'guid' => $guid
        ]);

        return $this->inflate($row);
    }

    /**
     * @param int $id
     *
     * @param int $status
     *
     * @return int
     */
    public function updateStatus(int $id, int $status): int
    {
        $sql = 'update cheques_callback_urls set updated_at=now(), status=:status where id=:id';

        return $this->update($sql, ['id' => $id, 'status' => $status]);
    }
}
