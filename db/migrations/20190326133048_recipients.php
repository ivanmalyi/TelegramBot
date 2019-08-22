<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

/**
 * Class Recipients
 */
class Recipients extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('recipients', [
            'primary_key' => 'id',
            'id' => false,

            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('item_id', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false])
            ->addColumn('template_id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('company_name', 'string', ['length' => 55, 'null' => false, 'default' => ''])
            ->addColumn('recipient_code', 'string', ['length' => 25, 'null' => false, 'default' => ''])
            ->addColumn('bank_name', 'string', ['length' => 55, 'null' => false, 'default' => ''])
            ->addColumn('bank_code', 'string', ['length' => 10, 'null' => false, 'default' => ''])
            ->addColumn('checking_account', 'string', ['length' => 25, 'null' => false, 'default' => ''])
            ->addIndex(['item_id'], ['unique' => true]);

        $table->create();
    }
}
