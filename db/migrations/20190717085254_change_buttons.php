<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class ChangeButtons extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('buttons');

        $table
            ->removeColumn('is_text_button')
            ->addColumn('button_type',  'enum', ['values' => ['text_button', 'main_menu_button', 'none'], 'null' => false, 'default' => 'none'])
            ->changeColumn('callback_action', 'enum', ['values' => ['get_main_menu', 'get_sections', 'add_card','get_operators', 'get_item_input_fields', 'get_card_list', 'del_card', 'none'], 'null' => false, 'default' => 'none'])
            ->changeColumn('value', 'char', ['length' => MysqlAdapter::TEXT_SMALL, 'null' => false, 'default' => '0'])

            ->update();
    }

    public function down()
    {
        $table = $this->table('buttons');

        $table
            ->addColumn('is_text_button', 'integer', ['limit' => MysqlAdapter::TEXT_SMALL, 'null' => false, 'signed' => false, 'default' => 0])
            ->removeColumn('button_type')
            ->changeColumn('callback_action', 'enum', ['values' => ['add_card','get_operators', 'get_item_input_fields', 'get_card_list', 'del_card', 'none'], 'null' => false, 'default' => 'none'])
            ->changeColumn('value', 'integer', ['limit'=>MysqlAdapter::INT_SMALL,'signed' => true, 'null' => false, 'default' => 0])

            ->update();
    }
}
