<?php


use Phinx\Migration\AbstractMigration;

class ChatsAddPhone extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('chats');
        $table
            ->addColumn('phone', 'string', ['length' => 15, 'null' => false, 'default' => ''])
            ->update();
    }

    public function down()
    {
        $table = $this->table('chats');
        $table
            ->removeColumn('phone')->update();
    }
}
