<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Messages extends AbstractMigration
{
    public function change()
    {
        $messages = $this->table('messages', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $messages
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('message', 'char', ['length' => 255, 'null' => false, 'default' => ''])
            ->addColumn('stage', 'integer', ['limit'=>MysqlAdapter::INT_TINY, 'null' => false])
            ->addColumn('status', 'integer', ['limit'=>MysqlAdapter::INT_TINY, 'null' => false]);

        $messages->create();
    }
}
