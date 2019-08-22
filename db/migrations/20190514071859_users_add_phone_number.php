<?php

use Phinx\Migration\AbstractMigration;

class UsersAddPhoneNumber extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('users');

        $table
            ->addColumn(
                'phone_number',
                'char',
                ['length' => 12, 'null' => false, 'default' => '', 'after' => 'last_name']
            )
            ->addIndex('phone_number')
            ->update();
    }

    public function down()
    {
        $table = $this->table('users');

        $table
            ->removeColumn('phone_number')
            ->update();
    }
}
