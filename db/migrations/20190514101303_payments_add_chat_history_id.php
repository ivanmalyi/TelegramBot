<?php

use Phinx\Migration\AbstractMigration;

/**
 * Class PaymentsAddChatHistoryId
 */
class PaymentsAddChatHistoryId extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('payments');

        $table
            ->addColumn('chat_history_id', 'integer', ['null' => false, 'signed' => false, 'default' => 0])
            ->update();
    }

    public function down()
    {
        $table = $this->table('payments');

        $table
            ->removeColumn('chat_history_id')
            ->update();
    }
}
