<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

/**
 * Class StagesMessages
 */
class StagesMessages extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('stages_messages', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('stage', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => true, 'default' => 0])
            ->addColumn('localization', 'enum', ['values' => ['UA', 'RU', 'EN'], 'null' => false, 'default' => 'RU'])
            ->addColumn('message', 'string', ['length' => 255, 'null' => false, 'default' => ''])
            ->addIndex(['stage', 'status', 'localization']);


        $table->create();
    }
}
