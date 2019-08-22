<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class StagesMessagesChangeMessage extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('stages_messages');

        $table
            ->changeColumn('message', 'text', [
                'length' => MysqlAdapter::TEXT_REGULAR,
                'null' => false,
                'default' => ''
            ])
            ->update();
    }

    public function down()
    {
        $table = $this->table('stages_messages');

        $table
            ->changeColumn('message', 'text', [
                'length' => MysqlAdapter::TEXT_SMALL,
                'null' => false,
                'default' => ''
            ])
            ->update();
    }
}
