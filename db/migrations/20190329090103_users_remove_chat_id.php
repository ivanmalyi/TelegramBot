<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class UsersRemoveChatId extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('users');

        $table
            ->removeColumn('chat_id')
            ->removeColumn('chat_bot_id')
            ->update();
    }

    public function down()
    {
        $table = $this->table('users');

        $table
            ->addColumn('chat_id', 'integer', ['signed' => false, 'null' => false, 'after' => 'id'])
            ->addColumn('chat_bot_id', 'integer', ['limit' => MysqlAdapter::INT_TINY,'signed' => false, 'null' => false])
            ->update();
    }
}
