<?php

use Phinx\Migration\AbstractMigration;

/**
 * Class ChatsAddColumns
 */
class ChatsAddColumns extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('chats');

        $table
            ->addColumn('current_cheque_id', 'integer', [
                'null' => false,
                'signed' => false,
                'default' => 0,
                'after' => 'current_sub_stage'
            ])
            ->addColumn('current_localization', 'enum', [
                'values' => ['UA', 'RU', 'EN'],
                'null' => false,
                'default' => 'RU',
                'after' => 'current_cheque_id'
            ])
            ->update();
    }

    public function down()
    {
        $table = $this->table('chats');

        $table
            ->removeColumn('current_cheque_id')
            ->removeColumn('current_localization')
            ->update();
    }
}
