<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class ButtonsAddIsTextButton extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('buttons');
        $table
            ->addColumn('is_text_button', 'integer', ['limit' => MysqlAdapter::TEXT_SMALL, 'null' => false, 'signed' => false, 'default' => 0])
            ->update();
    }

    public function down()
    {
        $table = $this->table('buttons');
        $table
            ->removeColumn('is_text_button')->update();
    }
}
