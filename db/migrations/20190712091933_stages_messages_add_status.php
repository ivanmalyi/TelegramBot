<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class StagesMessagesAddStatus extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('stages_messages');
        $table
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 1])
            ->update();
    }

    public function down()
    {
        $table = $this->table('stages_messages');
        $table
            ->removeColumn('status')
            ->update();
    }
}
