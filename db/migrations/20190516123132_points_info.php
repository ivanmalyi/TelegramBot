<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class PointsInfo extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('points_info', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('member_id', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('point_id', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('address', 'char', ['length' => MysqlAdapter::TEXT_SMALL, 'null' => false, 'default' => ''])
            ->addColumn('place', 'char', ['length' => MysqlAdapter::TEXT_SMALL, 'null' => false, 'default' => ''])
            ->addColumn('add_info', 'char', ['length' => MysqlAdapter::TEXT_SMALL, 'null' => false, 'default' => '']);

        $table->create();
    }
}
