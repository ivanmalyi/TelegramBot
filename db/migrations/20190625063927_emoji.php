<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Emoji extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('emoji', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('unicode', 'char', ['length' => MysqlAdapter::TEXT_SMALL, 'null' => false, 'default' => ''])
            ->addColumn('description', 'char', ['length' => MysqlAdapter::TEXT_SMALL, 'null' => false, 'default' => '']);

        $table->create();
    }
}
