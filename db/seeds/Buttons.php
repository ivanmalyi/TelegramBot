<?php


use Phinx\Seed\AbstractSeed;

class Buttons extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'callback_action' => 'none',
                'name' => 'Показать номер',
                'value'=>'0',
                'button_type'=>'text_button'
            ],
            [
                'id' => 2,
                'callback_action' => 'none',
                'name' => 'Обновить номер',
                'value'=>'0',
                'button_type'=>'text_button'
            ],
            [
                'id' => 3,
                'callback_action' => 'none',
                'name' => 'Меню',
                'value'=>'21',
                'button_type'=>'text_button'
            ],
            [
                'id' => 4,
                'callback_action' => 'none',
                'name' => 'Оплатить',
                'value'=>'0'
            ],
            [
                'id' => 5,
                'callback_action' => 'none',
                'name' => 'Поиск',
                'value'=>'17',
                'button_type'=>'text_button'
            ],
            [
                'id' => 6,
                'callback_action' => 'none',
                'name' => 'Пагинация (назад)',
                'value'=>'0'
            ],
            [
                'id' => 7,
                'callback_action' => 'none',
                'name' => 'Пагинация (вперед)',
                'value'=>'0'
            ],
            [
                'id' => 8,
                'callback_action' => 'none',
                'name' => 'Личный кабинет',
                'value'=>'19',
                'button_type'=>'text_button'
            ],
            [
                'id' => 9,
                'callback_action' => 'get_card_list',
                'name' => 'Получить список карт пользователя',
                'value'=>'0'
            ],
            [
                'id' => 10,
                'callback_action' => 'del_card',
                'name' => 'удалить карту',
                'value'=>'0'
            ],
            [
                'id' => 11,
                'callback_action' => 'get_item_input_fields',
                'name' => 'Пополнение мобильного',
                'value'=>'2931',
                'button_type'=>'main_menu_button'
            ],
            [
                'id' => 12,
                'callback_action' => 'get_item_input_fields',
                'name' => 'Ставки на спорт',
                'value'=>'3748;4332;1240;3878;1651;2243;884;4327;5776',
                'button_type'=>'main_menu_button'
            ],
            [
                'id' => 13,
                'callback_action' => 'get_item_input_fields',
                'name' => 'Такси',
                'value'=>'319',
                'button_type'=>'main_menu_button'
            ],
            [
                'id' => 14,
                'callback_action' => 'get_sections',
                'name' => 'Другие услуги',
                'value'=>'0',
                'button_type'=>'main_menu_button'
            ],
            [
                'id' => 15,
                'callback_action' => 'get_item_input_fields',
                'name' => 'Привязать текущий номер телефона к полю ввода',
                'value' => '0'
            ],
        ];

        $this->table('buttons')->insert($data)->save();
    }
}
