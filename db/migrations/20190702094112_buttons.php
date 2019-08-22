<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Buttons extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('buttons', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('callback_action', 'enum', ['values' => ['add_card','get_operators', 'get_item_input_fields', 'get_card_list', 'del_card', 'none'], 'null' => false, 'default' => 'none'])
            ->addColumn('name', 'char', ['length' => MysqlAdapter::TEXT_SMALL, 'null' => false, 'default' => ''])
            ->addColumn('value', 'integer', ['limit'=>MysqlAdapter::INT_SMALL,'signed' => true, 'null' => false, 'default' => 0]);

        $table->create();
    }
}
