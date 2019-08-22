<?php

use Phinx\Seed\AbstractSeed;

class CallbackUrls extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'callback_url_3ds' => 'http://chatbot:4000/telegram/callback_3ds',
                'callback_url_ok' => 'http://chatbot:4000/telegram/callback_ok',
                'callback_url_error' => 'http://chatbot:4000/telegram/callback_error',
                'chat_bot_id' => 1,
            ],
        ];

        $this->table('callback_urls')->insert($data)->save();
    }
}