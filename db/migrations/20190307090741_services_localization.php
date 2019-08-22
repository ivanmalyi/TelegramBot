<?php


use Phinx\Migration\AbstractMigration;

class ServicesLocalization extends AbstractMigration
{
    public function change()
    {
        $servicesLocalization = $this->table('services_localization', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $servicesLocalization
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('service_id', 'integer', ['signed' => false, 'null' => false, 'default' => 0])
            ->addColumn('localization', 'enum', ['values' => ['UA', 'RU', 'EN'], 'null' => false, 'default' => 'RU'])
            ->addColumn('name', 'char', ['length' => 80, 'null' => false, 'default' => '']);

        $servicesLocalization->create();
    }
}
