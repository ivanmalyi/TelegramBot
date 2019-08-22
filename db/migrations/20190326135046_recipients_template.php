<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class RecipientsTemplate extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('recipients_template', [
            'primary_key' => 'id',
            'id' => false,

            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('template_id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('localization', 'enum', ['values' => ['UA', 'RU', 'EN'], 'null' => false, 'default' => 'RU'])
            ->addColumn('name', 'string', ['length' => 255, 'null' => false, 'default' => ''])
            ->addIndex(['template_id']);

        $table->create();
    }
}
