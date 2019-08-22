<?php

use Phinx\Migration\AbstractMigration;
use \Phinx\Db\Adapter\MysqlAdapter;

class Users extends AbstractMigration
{
    public function change()
    {
        $users = $this->table('users', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $users
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('chat_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('first_name', 'char', ['length' => 100, 'null' => false, 'default' => ''])
            ->addColumn('last_name', 'char', ['length' => 100, 'null' => false, 'default' => ''])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('chat_bot_id', 'integer', ['limit' => MysqlAdapter::INT_TINY,'signed' => false, 'null' => false])
            ->addIndex(['chat_id', 'chat_bot_id'], ['unique' => true, 'name' => 'idx_chat_unique']);

        $users->create();
    }
}