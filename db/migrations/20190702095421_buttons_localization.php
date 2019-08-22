<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class ButtonsLocalization extends AbstractMigration
{

    public function change()
    {
        $table = $this->table('buttons_localization', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('button_id', 'integer', ['limit'=>MysqlAdapter::INT_SMALL,'signed' => true, 'null' => false, 'default' => 0])
            ->addColumn('name', 'char', ['length' => MysqlAdapter::TEXT_SMALL, 'null' => false, 'default' => ''])
        ->addColumn('localization', 'enum', ['values' => ['UA', 'RU', 'EN'], 'null' => false, 'default' => 'RU']);

        $table->create();
    }
}
