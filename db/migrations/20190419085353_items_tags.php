<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class ItemsTags extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('items_tags', [
            'primary_key' => 'item_id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('item_id', 'integer', ['limit'=>MysqlAdapter::INT_SMALL,'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('tags', 'text', ['null' => false, 'default' => '']);

        $table->create();
    }
}
