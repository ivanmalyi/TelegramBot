<?php


use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

/**
 * Class ChequesChangeBillingCheque
 */
class ChequesChangeBillingCheque extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('cheques');

        $table
            ->changeColumn('billing_cheque_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'signed' => false, 'default' => 0])
            ->update();
    }

    public function down()
    {
        $table = $this->table('cheques');

        $table
            ->changeColumn('billing_cheque_id', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'signed' => false, 'default' => 0])
            ->update();
    }
}
