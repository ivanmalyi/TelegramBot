<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class UserAds extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('user_ads', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('user_id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('guid', 'char', ['length' => 36, 'null' => false, 'default' => ''])
            ->addColumn('utm_source', 'string', ['length' => 255, 'null' => false, 'default' => ''])
            ->addColumn('utm_medium', 'string', ['length' => 255, 'null' => false, 'default' => ''])
            ->addColumn('utm_campaign', 'string', ['length' => 255, 'null' => false, 'default' => ''])
            ->addColumn('utm_content', 'string', ['length' => 255, 'null' => false, 'default' => ''])
            ->addColumn('utm_term', 'string', ['length' => 255, 'null' => false, 'default' => ''])
            ->addColumn('ref_original', 'string', ['length' => 500, 'null' => false, 'default' => ''])
            ->addTimestamps()
            ->addIndex(['guid', 'created_at'])
            ->addIndex(['user_id']);


        $table->create();
    }
}
