<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

/**
 * Class PaymentsRemoveOdd
 */
class PaymentsRemoveOdd extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('payments');

        $table
            ->removeColumn('user_id')
            ->addColumn('cheque_id', 'integer', [
                'signed' => false,
                'null' => false,
                'default' => 0,
                'after' => 'id'
            ])
            ->changeColumn('amount', 'integer', [
                'limit' => MysqlAdapter::INT_MEDIUM,
                'signed' => false,
                'default' => 0,
                'null' => false
            ])
            ->changeColumn('account', 'string', [
                'length' => 255,
                'null' => false,
                'default' => '',
                'after' => 'item_id'
            ])
            ->changeColumn('billing_cheque_id', 'integer', [
                'signed' => false,
                'null' => false,
                'default' => 0
            ])
            ->changeColumn('billing_payment_id', 'integer', [
                'signed' => false,
                'null' => false,
                'default' => 0
            ])
            ->changeColumn('status', 'integer', [
                'limit' => MysqlAdapter::INT_TINY,
                'signed' => false,
                'null' => false,
                'default' => 0,
                'after' => 'commission'
            ])
            ->removeColumn('stage')
            ->addIndex('cheque_id',['unique' => true])
            ->update();
    }

    public function down()
    {
        $table = $this->table('payments');

        $table
            ->addColumn('user_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('stage', 'integer', ['limit'=>MysqlAdapter::INT_TINY,'signed' => false, 'null' => false])
            ->removeColumn('cheque_id')
            ->update();
    }
}
