<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Display extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('display', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('cheque_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'signed' => false])
            ->addColumn('billing_pay_amount', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false])
            ->addColumn('billing_max_pay_amount', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false])
            ->addColumn('billing_min_pay_amount', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false])
            ->addColumn('is_modify_pay_amount', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false])
            ->addColumn('recipient', 'text', ['null' => false,  'default' => ''])
            ->addColumn('recipient_code', 'string', ['length' => 50, 'null' => false, 'default' => ''])
            ->addColumn('bank_name', 'string', ['length' => 50, 'null' => false, 'default' => ''])
            ->addColumn('bank_code', 'string', ['length' => 50, 'null' => false, 'default' => ''])
            ->addColumn('checking_account', 'string', ['length' => 50, 'null' => false, 'default' => '']);

        $table->create();
    }
}
