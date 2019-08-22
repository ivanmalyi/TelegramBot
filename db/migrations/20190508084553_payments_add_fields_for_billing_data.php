<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class PaymentsAddFieldsForBillingData extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('payments');

        $table
            ->addColumn('billing_status', 'integer', [
                'limit' => MysqlAdapter::INT_TINY,
                'signed' => true,
                'null' => false,
                'default' => 0
            ])->addColumn('acquiring_status', 'integer', [
                'limit' => MysqlAdapter::INT_TINY,
                'signed' => true,
                'null' => false,
                'default' => 0
            ])->addColumn('acquiring_transaction_id', 'integer', [
                'signed' => false,
                'null' => false,
                'default' => 0
            ])->addColumn('acquiring_merchant_id', 'string', [
                'length' => 15,
                'null' => false,
                'default' => ''
            ])->addColumn('acquiring_confirm_url', 'string', [
                'length' => 255,
                'null' => false,
                'default' => ''
            ])->addColumn('ps_id', 'integer', [
                'signed' => false,
                'null' => false,
                'default' => 0
            ])->addColumn('billing_operator_pay_id', 'integer', [
                'signed' => false,
                'null' => false,
                'default' => 0
            ])->addColumn('billing_operator_cheque_id', 'integer', [
                'signed' => false,
                'null' => false,
                'default' => 0
            ])
            ->update();
    }

    public function down()
    {
        $table = $this->table('payments');

        $table
            ->removeColumn('billing_status')
            ->removeColumn('acquiring_status')
            ->removeColumn('acquiring_confirm_url')
            ->removeColumn('acquiring_transaction_id')
            ->removeColumn('acquiring_merchant_id')
            ->removeColumn('ps_id')
            ->removeColumn('billing_operator_pay_id')
            ->removeColumn('billing_operator_cheque_id')
            ->update();
    }
}
