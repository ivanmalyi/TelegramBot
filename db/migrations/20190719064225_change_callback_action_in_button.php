<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class ChangeCallbackActionInButton extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('buttons');

        $table
            ->changeColumn('callback_action', 'enum', ['values' => ['get_items', 'get_services', 'get_main_menu', 'get_sections', 'add_card','get_operators', 'get_item_input_fields', 'get_card_list', 'del_card', 'none'], 'null' => false, 'default' => 'none'])

            ->update();
    }

    public function down()
    {
        $table = $this->table('buttons');

        $table
            ->changeColumn('callback_action', 'enum', ['values' => ['add_card','get_operators', 'get_item_input_fields', 'get_card_list', 'del_card', 'none'], 'null' => false, 'default' => 'none'])

            ->update();
    }
}
