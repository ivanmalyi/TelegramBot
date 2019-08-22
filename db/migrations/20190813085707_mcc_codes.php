<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class MccCodes extends AbstractMigration
{
    /**
     *
     */
    public function change()
    {
        $table = $this->table('mcc_codes', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'signed' => false])
            ->addColumn('name', 'string', ['length' => 35, 'null' => false, 'default' => ''])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false]);


        $table->create();
    }
}
