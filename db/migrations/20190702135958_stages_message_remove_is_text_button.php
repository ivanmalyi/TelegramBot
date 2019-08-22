<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class StagesMessageRemoveIsTextButton extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('stages_messages');

        $table->removeColumn('is_text_button')
            ->update();
    }

    public function down()
    {
        $table = $this->table('stages_messages');
        $table
            ->addColumn('is_text_button', 'integer', ['limit' => MysqlAdapter::TEXT_SMALL, 'null' => false, 'signed' => false, 'default' => 0])
            ->update();
    }
}
