<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class ChatsAddAttempts extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('chats');
        $table
            ->addColumn('attempts', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0])
            ->update();
    }

    public function down()
    {
        $table = $this->table('chats');
        $table
            ->removeColumn('attempts')->update();
    }
}
