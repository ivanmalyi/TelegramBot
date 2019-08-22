<?php

use Phinx\Migration\AbstractMigration;

class ChatsAddCurrentSessionGuid extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('chats');

        $table
            ->addColumn('current_session_guid', 'char', ['length' => 36, 'null' => false, 'default' => ''])
            ->update();
    }

    public function down()
    {
        $table = $this->table('chats');

        $table
            ->removeColumn('current_session_guid')
            ->update();
    }
}
