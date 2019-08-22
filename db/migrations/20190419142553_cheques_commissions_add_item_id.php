<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class ChequesCommissionsAddItemId extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('cheques_commissions');

        $table
            ->addColumn(
                'item_id',
                'integer',
                ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => false, 'default' => 0]
            )
            ->update();
    }

    public function down()
    {
        $table = $this->table('cheques_commissions');

        $table
            ->removeColumn('item_id')
            ->update();
    }
}
