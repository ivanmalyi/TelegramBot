<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Items extends AbstractMigration
{
    public function change()
    {
        $items = $this->table('items', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $items
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('service_id', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('image', 'char', ['length' => 45, 'null' => false, 'default' => ''])
            ->addColumn('min_amount', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('max_amount', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('status', 'integer', ['limit'=>MysqlAdapter::INT_TINY,'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('title', 'char', ['length' => 45, 'null' => false, 'default' => '']);

        $items->create();
    }
}
