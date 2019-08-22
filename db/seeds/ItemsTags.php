<?php


use Phinx\Seed\AbstractSeed;

class ItemsTags extends AbstractSeed
{

    public function run()
    {
        $data = [
            [
                'item_id'=>1,
                'tags'=>'Киевстар'
            ]
        ];

        $this->table('items_tags')->insert($data)->save();
    }
}
