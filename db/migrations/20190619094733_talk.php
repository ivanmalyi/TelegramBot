<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Talk extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('talk', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('status', 'integer', ['limit'=>MysqlAdapter::INT_TINY,'signed' => true, 'null' => false, 'default' => 0])
            ->addColumn('question', 'string', ['length' => 255, 'null' => false, 'default' => ''])
            ->addColumn('answer', 'string', ['length' => 255, 'null' => false, 'default' => ''])
            ->addIndex(['status'], ['name' => 'status_index']);

        $table->create();
    }
}
