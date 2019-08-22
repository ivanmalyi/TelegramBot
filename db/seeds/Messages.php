<?php

use Phinx\Seed\AbstractSeed;

/**
 * Class Messages
 */
class Messages extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'message' => 'Не понятно, что вы написали',
                'stage' => -1
            ],
            [
                'message' => 'Приветствую, (fio), Нажмите на кнопку # Новый платеж #, что бы совершить платеж',
                'stage' => 1
            ],
            [
                'message' => 'Выберите раздел',
                'stage' => 3
            ],
            [
                'message' => 'Выберите провайдера',
                'stage' => 4
            ],
            [
                'message' => 'Введите аккаунт',
                'stage' => 5
            ],
            [
                'message' => 'Аккаунт не найден',
                'stage' => 6,
                'status'=> -35
            ],
            [
                'message' => 'Аккаунт забанен',
                'stage' => 6,
                'status'=> -34
            ],
            [
                'message' => 'Сервис временно недоступен',
                'stage' => 6,
                'status'=> -40
            ],
            [
                'message' => 'Данный провадер отсутствует',
                'stage' => 6,
                'status'=> -45
            ],
            [
                'message' => 'Действие невозможно',
                'stage' => 6,
                'status'=> -41
            ],
        ];

        $this->table('messages')->insert($data)->save();
    }
}