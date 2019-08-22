<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

/**
 * Class ChatsAddSubStage
 */
class ChatsAddSubStage extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('chats');

        $table
            ->addColumn('current_sub_stage', 'integer', [
                'limit' => MysqlAdapter::INT_SMALL,
                'null' => false,
                'signed' => false,
                'default' => 0,
                'after' => 'current_stage'
            ])
            ->update();
    }

    public function down()
    {
        $table = $this->table('chats');

        $table
            ->removeColumn('current_sub_stage')
            ->update();
    }
}
