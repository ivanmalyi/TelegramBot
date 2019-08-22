<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Commissions extends AbstractMigration
{
    public function change()
    {
        $commissions = $this->table('commissions', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $commissions
            ->addColumn('id', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('item_id', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('commission_type', 'integer', ['limit'=>MysqlAdapter::INT_TINY,'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('amount', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('algorithm', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('from_amount', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('to_amount', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('min_amount', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('max_amount', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('from_time', 'time', ['null' => false])
            ->addColumn('to_time', 'time', [ 'null' => false])
            ->addColumn('round', 'integer', ['limit'=>MysqlAdapter::INT_TINY,'signed' => false, 'null' => false, 'default' => 0])
            ->addIndex(['item_id'], ['name' => 'commissions_item_id_index']);

        $commissions->create();
    }
}
