<?php


use Phinx\Migration\AbstractMigration;

class OperatorsLocalization extends AbstractMigration
{
    public function change()
    {
        $operatorsLocalization = $this->table('operators_localization', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $operatorsLocalization
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('operator_id', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('localization', 'enum', ['values' => ['UA', 'RU', 'EN'], 'null' => false, 'default' => 'RU'])
            ->addColumn('name', 'char', ['length' => 80, 'null' => false, 'default' => ''])
            ->addColumn('description', 'text', ['null' => false, 'default' => '']);

        $operatorsLocalization->create();
    }
}
