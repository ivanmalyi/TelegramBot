<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class ChatsHistory extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('chats_history', [
            'primary_key' => 'id',
            'id' => false,

            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['identity' => true, 'null' => false, 'signed' => false])
            ->addColumn('chat_id', 'integer', ['null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('user_id', 'integer', ['null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('stage', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('sub_stage', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('localization', 'enum', ['values' => ['UA', 'RU', 'EN'], 'null' => false, 'default' => 'RU'])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('session_guid', 'char', ['length' => 36, 'null' => false, 'default' => ''])
            ->addIndex(['created_at', 'chat_id'])
            ->addIndex('session_guid');

        $table->create();
    }
}
