<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class AcquiringCommission extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('acquiring_commission', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('cheque_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'signed' => false])
            ->addColumn('amount', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false])
            ->addColumn('algorithm', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false])
            ->addColumn('from_amount', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false])
            ->addColumn('to_amount', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false])
            ->addColumn('min_amount', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false])
            ->addColumn('max_amount', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false]);
        $table->create();
    }
}
