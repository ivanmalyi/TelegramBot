<?php

use Phinx\Migration\AbstractMigration;

/**
 * Class ChequesChangeStatus
 */
class ChequesChangeStatus extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('cheques');

        $table
            ->renameColumn('status_id', 'status')
            ->update();
    }

    public function down()
    {
        $table = $this->table('cheques');

        $table
            ->renameColumn('status', 'status_id')
            ->update();
    }
}
