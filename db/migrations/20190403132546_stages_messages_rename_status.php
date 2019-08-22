<?php


use Phinx\Migration\AbstractMigration;

class StagesMessagesRenameStatus extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('stages_messages');

        $table
            ->renameColumn('status', 'sub_stage')
            ->update();
    }

    public function down()
    {
        $table = $this->table('stages_messages');

        $table
            ->renameColumn('sub_stage', 'status')
            ->update();
    }
}
