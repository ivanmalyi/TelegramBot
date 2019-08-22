<?php


use Phinx\Seed\AbstractSeed;

class ButtonsLocalization extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'button_id' => 1,
                'localization' => 'RU',
                'name' => "Показать номер {{emoji_1}}"
            ],
            [
                'button_id' => 1,
                'localization' => 'UA',
                'name' => "Показати номер {{emoji_1}}"
            ],
            [
                'button_id' => 1,
                'localization' => 'EN',
                'name' => "Show number {{emoji_1}}"
            ],
            [
                'button_id' => 2,
                'localization' => 'RU',
                'name' => "Обновить номер {{emoji_1}} {{emoji_2}}"
            ],
            [
                'button_id' => 2,
                'localization' => 'UA',
                'name' => "Оновити номер {{emoji_1}} {{emoji_2}}"
            ],
            [
                'button_id' => 2,
                'localization' => 'EN',
                'name' => "Update number {{emoji_1}} {{emoji_2}}"
            ],
            [
                'button_id' => 3,
                'localization' => 'RU',
                'name' => "Меню {{emoji_3}}"
            ],
            [
                'button_id' => 3,
                'localization' => 'UA',
                'name' => "Меню {{emoji_3}}"
            ],
            [
                'button_id' => 3,
                'localization' => 'EN',
                'name' => "Menu {{emoji_3}}"
            ],
            [
                'button_id' => 4,
                'localization' => 'RU',
                'name' => "Оплатить {{emoji_4}}"
            ],
            [
                'button_id' => 4,
                'localization' => 'UA',
                'name' => "Оплатити {{emoji_4}}"
            ],
            [
                'button_id' => 4,
                'localization' => 'EN',
                'name' => "Pay {{emoji_4}}"
            ],
            [
                'button_id' => 5,
                'localization' => 'RU',
                'name' => "Поиск {{emoji_5}}"
            ],
            [
                'button_id' => 5,
                'localization' => 'UA',
                'name' => "Пошук {{emoji_5}}"
            ],
            [
                'button_id' => 5,
                'localization' => 'EN',
                'name' => "Search {{emoji_5}}"
            ],
            [
                'button_id' => 6,
                'localization' => 'RU',
                'name' => "{{emoji_6}}"
            ],
            [
                'button_id' => 6,
                'localization' => 'UA',
                'name' => "{{emoji_6}}"
            ],
            [
                'button_id' => 6,
                'localization' => 'EN',
                'name' => "{{emoji_6}}"
            ],
            [
                'button_id' => 7,
                'localization' => 'RU',
                'name' => "{{emoji_7}}"
            ],
            [
                'button_id' => 7,
                'localization' => 'UA',
                'name' => "{{emoji_7}}"
            ],
            [
                'button_id' => 7,
                'localization' => 'EN',
                'name' => "{{emoji_7}}"
            ],
            [
                'button_id' => 8,
                'localization' => 'RU',
                'name' => "Личный кабинет{{emoji_8}}"
            ],
            [
                'button_id' => 8,
                'localization' => 'UA',
                'name' => "Особистий кабінет{{emoji_8}}"
            ],
            [
                'button_id' => 8,
                'localization' => 'EN',
                'name' => "Private office{{emoji_8}}"
            ],
            [
                'button_id' => 9,
                'localization' => 'RU',
                'name' => "Список карт{{emoji_4}}"
            ],
            [
                'button_id' => 9,
                'localization' => 'UA',
                'name' => "Список карт{{emoji_4}}"
            ],
            [
                'button_id' => 9,
                'localization' => 'EN',
                'name' => "Card list{{emoji_4}}"
            ],
            [
                'button_id' => 10,
                'localization' => 'RU',
                'name' => "Удалить карту{{emoji_9}}"
            ],
            [
                'button_id' => 10,
                'localization' => 'UA',
                'name' => "Видалити карту{{emoji_9}}"
            ],
            [
                'button_id' => 10,
                'localization' => 'EN',
                'name' => "Delete card{{emoji_9}}"
            ],
            [
                'button_id' => 11,
                'localization' => 'RU',
                'name' => "Пополнение мобильного"
            ],
            [
                'button_id' => 11,
                'localization' => 'UA',
                'name' => "Поповнення мобильного"
            ],
            [
                'button_id' => 11,
                'localization' => 'EN',
                'name' => "Recharge mobile phone"
            ],
            [
                'button_id' => 12,
                'localization' => 'RU',
                'name' => "Ставки на спорт"
            ],
            [
                'button_id' => 12,
                'localization' => 'UA',
                'name' => "Ставки на спорт"
            ],
            [
                'button_id' => 12,
                'localization' => 'EN',
                'name' => "Sports betting"
            ],
            [
                'button_id' => 13,
                'localization' => 'RU',
                'name' => "Такси"
            ],
            [
                'button_id' => 13,
                'localization' => 'UA',
                'name' => "Таксі"
            ],
            [
                'button_id' => 13,
                'localization' => 'EN',
                'name' => "Taxi"
            ],
            [
                'button_id' => 14,
                'localization' => 'RU',
                'name' => "Другие услуги"
            ],
            [
                'button_id' => 14,
                'localization' => 'UA',
                'name' => "Інші послуги"
            ],
            [
                'button_id' => 14,
                'localization' => 'EN',
                'name' => "Other services"
            ],
            [
                'button_id' => 15,
                'localization' => 'RU',
                'name' => "{current_phone_number}"
            ],
            [
                'button_id' => 15,
                'localization' => 'UA',
                'name' => "{current_phone_number}"
            ],
            [
                'button_id' => 15,
                'localization' => 'EN',
                'name' => "{current_phone_number}"
            ]
        ];

        $this->table('buttons_localization')->insert($data)->save();
    }
}
