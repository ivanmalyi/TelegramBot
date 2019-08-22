<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class ItemsAddMcc extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('items');

        $table
            ->addColumn('mcc', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'signed' => false, 'null' => false, 'default' => 0])
            ->update();
    }

    public function down()
    {
        $table = $this->table('items');

        $table
            ->removeColumn('mcc')
            ->update();
    }
}
