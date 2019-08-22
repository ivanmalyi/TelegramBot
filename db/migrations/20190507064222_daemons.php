<?php

use Phinx\Migration\AbstractMigration;

class Daemons extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('daemons', [
            'primary_key' => 'id',
            'id' => false,

            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['identity' => true, 'limit' => 16777215, 'null' => false, 'signed' => false])
            ->addColumn('name', 'string', ['length' => 35, 'null' => false, 'default' => ''])
            ->addColumn('status', 'integer', ['limit' => 255, 'signed' => true, 'null' => false]);

        $table->create();
    }
}
