<?php

use Phinx\Migration\AbstractMigration;

class Notifications extends AbstractMigration
{

    public function change()
    {
        $notifications = $this->table('notifications', [
            'primary_key' => 'id',
            'id' => false,

            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $notifications
            ->addColumn('id', 'integer', ['identity' => true, 'limit' => 16777215, 'null' => false, 'signed' => false])
            ->addColumn('source', 'string', ['length' => 20, 'null' => false, 'default' => ''])
            ->addColumn('type', 'enum', ['values' => ["email","telegram"], 'default' => "email", 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('message', 'string', ['length' => 255, 'null' => false, 'default' => ''])
            ->addIndex(['source'], ['name' => 'source']);

        $notifications->create();
    }
}
