<?php


use Phinx\Migration\AbstractMigration;

class ItemInputFieldsLocalization extends AbstractMigration
{
    public function change()
    {
        $itemInputFieldsLocalization = $this->table('items_input_fields_localization', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $itemInputFieldsLocalization
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('items_input_id', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('localization', 'enum', ['values' => ['UA', 'RU', 'EN'], 'null' => false, 'default' => 'RU'])
            ->addColumn('field_name', 'char', ['length' => 80, 'null' => false, 'default' => ''])
            ->addColumn('instruction', 'text', ['null' => false, 'default' => '']);

        $itemInputFieldsLocalization->create();
    }
}
