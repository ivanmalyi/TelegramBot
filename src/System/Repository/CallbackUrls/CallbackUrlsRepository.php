<?php

declare(strict_types=1);

namespace System\Repository\CallbackUrls;

use System\Entity\Repository\CallbackUrl;
use System\Repository\AbstractPdoRepository;

/**
 * Class CallBackUrlsRepository
 * @package System\Repository\CallBackUrls
 */
class CallbackUrlsRepository extends AbstractPdoRepository implements CallbackUrlsRepositoryInterface
{
    /**
     * @param int $chatBitId
     *
     * @return CallbackUrl
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findCallBackUrl(int $chatBitId): CallbackUrl
    {
        $sql = 'select id, callback_url_3ds, callback_url_ok, callback_url_error, chat_bot_id
                from callback_urls
                where chat_bot_id = :chatBotId
                order by id desc limit 1';

        $row = $this->execAssocOne($sql, ['chatBotId'=>$chatBitId]);

        return $this->inflate($row);
    }

    /**
     * @param array $row
     *
     * @return CallbackUrl
     */
    private function inflate(array $row): CallbackUrl
    {
        return new CallbackUrl(
            $row['callback_url_3ds'],
            $row['callback_url_ok'],
            $row['callback_url_error'],
            (int)$row['chat_bot_id'],
            (int)$row['id']
        );
    }
}