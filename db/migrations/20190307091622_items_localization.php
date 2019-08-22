<?php


use Phinx\Migration\AbstractMigration;

class ItemsLocalization extends AbstractMigration
{
    public function change()
    {
        $itemsLocalization = $this->table('items_localization', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $itemsLocalization
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('item_id', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('localization', 'enum', ['values' => ['UA', 'RU', 'EN'], 'null' => false, 'default' => 'RU'])
            ->addColumn('name', 'char', ['length' => 80, 'null' => false, 'default' => ''])
            ->addColumn('description', 'text', ['null' => false, 'default' => '']);

        $itemsLocalization->create();
    }
}
