<?php

declare(strict_types=1);

namespace System\Repository\BillingSettings;

use System\Entity\Repository\BillingSettings;
use System\Repository\AbstractPdoRepository;

/**
 * Class BotKeysRepository
 * @package System\Repository\BotKeys
 */
class BillingSettingsRepository extends AbstractPdoRepository implements BillingSettingsRepositoryInterface
{
    /**
     * @return BillingSettings
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findParams(): BillingSettings
    {
        $sql = 'select id, login, password, url, public_key, private_key, client_key
                from billing_settings
                order by id desc limit 1';

        $row = $this->execAssocOne($sql, []);

        return $this->inflate($row);
    }

    /**
     * @param array $row
     * @return BillingSettings
     */
    private function inflate(array $row): BillingSettings
    {
        return new BillingSettings(
            $row['login'],
            $row['password'],
            $row['url'],
            $row['public_key'],
            $row['private_key'],
            $row['client_key'],
            (int)$row['id']
        );
    }

    public function updateKeys(string $publicKey, string $privateKey): int
    {
        $sql = 'update billing_settings 
                set public_key = :publicKey, private_key = :privateKey';
        $params = [
            'publicKey'=>$publicKey,
            'privateKey'=>$privateKey
        ];

        return $this->update($sql, $params);
    }
}