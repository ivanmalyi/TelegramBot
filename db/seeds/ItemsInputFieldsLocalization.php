<?php


use Phinx\Seed\AbstractSeed;

class ItemsInputFieldsLocalization extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id'=>1,
                'items_input_id'=>1,
                'localization'=>'UA',
                'field_name'=>'номер телефону',
                'instruction'=>'Введіть номер телефону'
            ],
            [
                'id'=>2,
                'items_input_id'=>1,
                'localization'=>'RU',
                'field_name'=>'номер телефона',
                'instruction'=>'Введите номер телефона.'
            ],
        ];

        $this->table('items_input_fields_localization')->insert($data)->save();
    }
}
