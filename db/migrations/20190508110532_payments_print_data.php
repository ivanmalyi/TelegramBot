<?php

use Phinx\Migration\AbstractMigration;

class PaymentsPrintData extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('payments_print_data', [
            'primary_key' => 'id',
            'id' => false,

            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['identity' => true, 'null' => false, 'signed' => false])
            ->addColumn('payment_id', 'integer', ['null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('text', 'string', ['length' => 25, 'null' => false, 'default' => ''])
            ->addColumn('value', 'string', ['length' => 255, 'null' => false, 'default' => ''])
            ->addColumn('target', 'string', ['length' => 25, 'null' => false, 'default' => '']);

        $table->create();
    }
}
