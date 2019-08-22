<?php


use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class SubStageMakeSigned extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('chats_history');
        $table
            ->changeColumn('sub_stage', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => true, 'default' => 0])
            ->update();

        $table = $this->table('chats');
        $table
            ->changeColumn('current_sub_stage', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => true, 'default' => 0])
            ->update();
    }

    public function down()
    {
        $table = $this->table('chats_history');
        $table
            ->changeColumn('sub_stage', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => false, 'default' => 0])
            ->update();

        $table = $this->table('chats');
        $table
            ->changeColumn('current_sub_stage', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => false, 'default' => 0])
            ->update();
    }
}
