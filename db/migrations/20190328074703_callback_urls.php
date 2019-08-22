<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CallbackUrls extends AbstractMigration
{
    public function change()
    {
        $callbackUrl = $this->table('callback_urls', [
            'primary_key' => 'id',
            'id' => false,
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ]);

        $callbackUrl
            ->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('callback_url_ok', 'char', ['length' => 255, 'null' => false, 'default' => ''])
            ->addColumn('callback_url_error', 'char', ['length' => 255, 'null' => false, 'default' => ''])
            ->addColumn('chat_bot_id', 'integer', ['limit'=>MysqlAdapter::INT_TINY, 'null' => false]);


        $callbackUrl->create();
    }
}
