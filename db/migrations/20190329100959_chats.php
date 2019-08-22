<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

/**
 * Class Chats
 */
class Chats extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('chats', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('user_id', 'integer', ['null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('current_stage', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('provider_chat_id', 'integer', ['limit' => MysqlAdapter::INT_BIG, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('chat_bot_id', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false, 'null' => false, 'default' => 0]);


        $table->create();
    }
}
