<?php

use Phinx\Migration\AbstractMigration;

class PaymentsAddIndex extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('payments');

        $table
            ->addIndex(['status'])
            ->update();
    }

    public function down()
    {
        $table = $this->table('payments');

        $table
            ->removeIndex(['status'])
            ->update();
    }
}
