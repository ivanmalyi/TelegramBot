<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

/**
 * Class PaymentSystems
 */
class PaymentSystems extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('payment_systems', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'identity' => true, 'signed' => false])
            ->addColumn('name', 'string', ['length' => 45, 'null' => false, 'default' => '']);

        $table->create();
    }
}
