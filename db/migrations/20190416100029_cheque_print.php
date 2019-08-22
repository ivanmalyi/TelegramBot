<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class ChequePrint extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('cheque_print', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('cheque_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'signed' => false])
            ->addColumn('text', 'string', ['length' => 50, 'null' => false, 'default' => ''])
            ->addColumn('value', 'string', ['length' => 50, 'null' => false, 'default' => ''])
            ->addColumn('target', 'string', ['length' => 50, 'null' => false, 'default' => '']);

        $table->create();
    }
}
