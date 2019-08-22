<?php


use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class ChequeAddPaymentSystemId extends AbstractMigration
{
        public function up()
    {
        $table = $this->table('cheques');
        $table
            ->addColumn('payment_system_id', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 1])
            ->update();
    }

        public function down()
    {
        $table = $this->table('cheques');
        $table
            ->removeColumn('payment_system_id')
            ->update();
    }
}
