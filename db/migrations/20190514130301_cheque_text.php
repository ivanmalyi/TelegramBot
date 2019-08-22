<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class ChequeText extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('cheques_text', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('cheque_id', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('text', 'text', ['length' => MysqlAdapter::TEXT_REGULAR, 'null' => false, 'default' => '']);

        $table->create();
    }
}
