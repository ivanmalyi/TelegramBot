<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class ItemTypes extends AbstractMigration
{
    public function change()
    {
        $itemTypes = $this->table('item_types', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $itemTypes
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('item_id', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('type', 'integer', ['limit'=>MysqlAdapter::INT_TINY,'signed' => false, 'null' => false, 'default' => 0]);

        $itemTypes->create();
    }
}
