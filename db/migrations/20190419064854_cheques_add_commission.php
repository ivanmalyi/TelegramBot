<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class ChequesAddCommission extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('cheques');

        $table
            ->addColumn('commission', 'integer', [
                'limit' => MysqlAdapter::INT_MEDIUM,
                'null' => false,
                'signed' => false,
                'default' => 0,
                'after' => 'amount'
            ])
            ->update();
    }

    public function down()
    {
        $table = $this->table('cheques');

        $table
            ->removeColumn('commission')
            ->update();
    }
}
