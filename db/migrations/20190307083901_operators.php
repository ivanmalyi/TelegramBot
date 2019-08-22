<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Operators extends AbstractMigration
{
    public function change()
    {
        $operators = $this->table('operators', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $operators
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('section_id', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('image', 'char', ['length' => 45, 'null' => false, 'default' => ''])
            ->addColumn('status', 'integer', ['limit'=>MysqlAdapter::INT_TINY,'signed' => false, 'null' => false, 'default' => 0]);

        $operators->create();
    }
}
