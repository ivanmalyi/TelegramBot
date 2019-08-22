<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class ItemsInputFields extends AbstractMigration
{
    public function change()
    {
        $itemsInputFields = $this->table('items_input_fields', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $itemsInputFields
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('item_id', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('order', 'integer', ['limit'=>MysqlAdapter::INT_TINY,'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('min_length', 'integer', ['limit'=>MysqlAdapter::INT_TINY,'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('max_length', 'integer', ['limit'=>MysqlAdapter::INT_TINY,'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('pattern', 'char', ['length' => 255, 'signed' => false, 'null' => false, 'default' => ''])
            ->addColumn('is_mobile', 'integer', ['limit'=>MysqlAdapter::INT_TINY,'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('typing_style', 'integer', ['limit'=>MysqlAdapter::INT_TINY,'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('prefixes', 'char', ['length' => 255, 'signed' => false, 'null' => false, 'default' => '']);

        $itemsInputFields->create();
    }
}
