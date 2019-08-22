<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Services extends AbstractMigration
{

    public function change()
    {
        $services = $this->table('services', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $services
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('operator_id', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('service_type_id', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('image', 'char', ['length' => 45, 'null' => false, 'default' => ''])
            ->addColumn('status', 'integer', ['limit'=>MysqlAdapter::INT_TINY,'signed' => false, 'null' => false, 'default' => 0]);

        $services->create();
    }
}
