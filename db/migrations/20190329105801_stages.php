<?php

use Phinx\Migration\AbstractMigration;

/**
 * Class Stages
 */
class Stages extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('stages', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('name', 'string', ['length' => 45, 'null' => false, 'default' => ''])
            ->addColumn('description', 'string', ['length' => 255, 'null' => false, 'default' => '']);


        $table->create();
    }
}
