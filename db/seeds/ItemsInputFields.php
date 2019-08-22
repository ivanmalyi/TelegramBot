<?php


use Phinx\Seed\AbstractSeed;

class ItemsInputFields extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id'=>1,
                'item_id'=>1,
                'order'=>1,
                'min_length'=>0,
                'max_length'=>0,
                'pattern'=>'',
                'is_mobile'=>0,
                'typing_style'=>0,
                'prefixes'=>''
            ]
        ];

        $this->table('items_input_fields')->insert($data)->save();
    }
}
