<?php


use Phinx\Seed\AbstractSeed;

class Items extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id'=>6,
                'service_id'=>47,
                'image'=>'',
                'min_amount'=>1,
                'max_amount'=>250000,
                'status'=>1,
                'title'=>''
            ],
            [
                'id'=>7,
                'service_id'=>47,
                'image'=>'',
                'min_amount'=>1,
                'max_amount'=>250000,
                'status'=>1,
                'title'=>''
            ],
            [
                'id'=>1,
                'service_id'=>42,
                'image'=>'',
                'min_amount'=>1,
                'max_amount'=>300000,
                'status'=>1,
                'title'=>''
            ],
        ];

        $this->table('items')->insert($data)->save();
    }
}
