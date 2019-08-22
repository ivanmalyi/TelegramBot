<?php


use Phinx\Migration\AbstractMigration;

class Sections extends AbstractMigration
{
    public function change()
    {
        $sections = $this->table('sections', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $sections
            ->addColumn('id', 'integer',   ['identity' => true, 'signed' => false])
            ->addColumn('name_ua', 'char', ['length' => 45, 'null' => false, 'default' => ''])
            ->addColumn('name_ru', 'char', ['length' => 45, 'null' => false, 'default' => ''])
            ->addColumn('name_en', 'char', ['length' => 45, 'null' => false, 'default' => '']);

        $sections->create();
    }
}
