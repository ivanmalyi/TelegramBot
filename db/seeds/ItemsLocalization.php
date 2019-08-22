<?php


use Phinx\Seed\AbstractSeed;

class ItemsLocalization extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id'=>1,
                'item_id'=>1,
                'localization'=>'UA',
                'name'=>'Київстар',
                'description'=>''
            ],
            [
                'id'=>2,
                'item_id'=>1,
                'localization'=>'RU',
                'name'=>'Киевстар',
                'description'=>''
            ],
            [
                'id'=>3,
                'item_id'=>6,
                'localization'=>'UA',
                'name'=>'МТС',
                'description'=>''
            ],
            [
                'id'=>4,
                'item_id'=>6,
                'localization'=>'RU',
                'name'=>'МТС',
                'description'=>''
            ],
            [
                'id'=>5,
                'item_id'=>7,
                'localization'=>'UA',
                'name'=>'МТС2',
                'description'=>''
            ],
            [
                'id'=>6,
                'item_id'=>7,
                'localization'=>'RU',
                'name'=>'МТС2',
                'description'=>''
            ],
        ];

        $this->table('items_localization')->insert($data)->save();
    }
}
