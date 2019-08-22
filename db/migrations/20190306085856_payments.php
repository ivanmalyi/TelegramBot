<?php

use Phinx\Migration\AbstractMigration;
use \Phinx\Db\Adapter\MysqlAdapter;

class Payments extends AbstractMigration
{
    public function change()
    {
        $payments = $this->table('payments', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $payments
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('user_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('account', 'char', ['length' => 155, 'null' => false, 'default' => ''])
            ->addColumn('item_id', 'integer', ['limit' => 65535, 'signed' => false, 'null' => false])
            ->addColumn('amount', 'integer', ['signed' => false, 'default' => 0, 'null' => false])
            ->addColumn('commission', 'integer', ['limit' => 65535,'default' => 0, 'signed' => false, 'null' => false])
            ->addColumn('billing_cheque_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('billing_payment_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('status', 'integer', ['limit'=>MysqlAdapter::INT_TINY,'signed' => false, 'null' => false])
            ->addColumn('stage', 'integer', ['limit'=>MysqlAdapter::INT_TINY,'signed' => false, 'null' => false]);

        $payments->create();
    }
}
