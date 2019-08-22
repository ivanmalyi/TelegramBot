<?php

use Phinx\Seed\AbstractSeed;

/**
 * Class BillingSettings
 */
class BillingSettings extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'login' => 'adg',
                'password' => 'adgjm',
                'url' => 'http://vagrant/sistema.billing/public/',
                'public_key' => '',
                'private_key' => '',
                'client_key' => 'chat_bot'
            ]
        ];

        $this->table('billing_settings')->insert($data)->save();
    }
}
