<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Cheques extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('cheques', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('chat_id', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('user_id', 'integer', ['null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('account', 'char', ['length' => 155, 'null' => false, 'default' => ''])
            ->addColumn('item_id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('amount', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('status_id', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('billing_cheque_id', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false, 'default' => 0]);

        $table->create();
    }
}
