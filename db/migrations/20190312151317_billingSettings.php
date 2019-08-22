<?php


use Phinx\Migration\AbstractMigration;

class BillingSettings extends AbstractMigration
{
    public function change()
    {
        $billingSettings = $this->table('billing_settings', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $billingSettings
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('login', 'char', ['length' => 50, 'null' => false, 'default' => ''])
            ->addColumn('password', 'char', ['length' => 50, 'null' => false, 'default' => ''])
            ->addColumn('url', 'char', ['length' => 255, 'null' => false, 'default' => ''])
            ->addColumn('public_key', 'text', ['null' => false,  'default' => ''])
            ->addColumn('private_key', 'text', ['null' => false, 'default' => ''])
            ->addColumn('client_key', 'char', ['length' => 50, 'null' => false, 'default' => '']);

        $billingSettings->create();
    }
}
