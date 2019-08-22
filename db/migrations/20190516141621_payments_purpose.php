<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class PaymentsPurpose extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('payments_purpose', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('item_id', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('localization', 'enum', ['values' => ['UA', 'RU', 'EN'], 'null' => false, 'default' => 'RU'])
            ->addColumn('purpose', 'char', ['length' => MysqlAdapter::TEXT_SMALL, 'null' => false, 'default' => '']);

        $table->create();
    }
}
