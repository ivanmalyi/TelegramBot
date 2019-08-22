<?php

use Phinx\Migration\AbstractMigration;

class CallbackUrlsAdd3ds extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('callback_urls');

        $table
            ->addColumn('callback_url_3ds', 'string', ['length' => 255, 'null' => false, 'default' => '', 'after' => 'id'])
            ->changeColumn('callback_url_ok', 'string', ['length' => 255, 'null' => false, 'default' => ''])
            ->changeColumn('callback_url_error', 'string', ['length' => 255, 'null' => false, 'default' => ''])
            ->update();
    }

    public function down()
    {
        $table = $this->table('callback_urls');

        $table
            ->removeColumn('callback_url_3ds')
            ->changeColumn('callback_url_ok', 'char', ['length' => 255, 'null' => false, 'default' => ''])
            ->changeColumn('callback_url_error', 'char', ['length' => 255, 'null' => false, 'default' => ''])
            ->update();
    }
}
