<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class PaymentsChangeStatus extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('payments');

        $table
            ->changeColumn('status', 'integer', [
                'limit' => MysqlAdapter::INT_SMALL,
                'signed' => true,
                'null' => false,
                'default' => 0,
                'after' => 'commission'
            ])
            ->update();
    }

    public function down()
    {
        $table = $this->table('payments');

        $table
            ->changeColumn('status', 'integer', [
                'limit' => MysqlAdapter::INT_TINY,
                'signed' => false,
                'null' => false,
                'default' => 0,
                'after' => 'commission'
            ])
            ->update();
    }
}
