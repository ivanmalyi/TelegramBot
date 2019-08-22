<?php

use Phinx\Migration\AbstractMigration;

class ChequesCommissions extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('cheques_commissions', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('cheque_id', 'integer', ['null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('commission_id', 'integer', ['null' => false, 'signed' => false, 'default' => 0])
            ->addIndex('cheque_id');

        $table->create();
    }
}
