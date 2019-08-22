<?php


use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class PaymentSystemsLocalization extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('payment_systems_headers_localization', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'identity' => true, 'signed' => false])
            ->addColumn('payment_system_id', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('localization', 'enum', ['values' => ['UA', 'RU', 'EN'], 'null' => false, 'default' => 'RU'])
            ->addColumn('text', 'string', ['length' => 255, 'null' => false, 'default' => ''])
            ->addIndex(['payment_system_id']);

        $table->create();
    }
}
