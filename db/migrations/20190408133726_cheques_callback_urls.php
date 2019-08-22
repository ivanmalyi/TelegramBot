<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class ChequesCallbackUrls extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('cheques_callback_urls', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('guid', 'string', ['length' => 25, 'null' => false, 'default' => ''])
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => true, 'default' => 0])
            ->addColumn('cheque_id', 'integer', ['null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('callback_url_id', 'integer', ['null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addIndex('cheque_id', ['unique' => true])
            ->addIndex('guid', ['unique' => true]);

        $table->create();
    }
}
