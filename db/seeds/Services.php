<?php


use Phinx\Seed\AbstractSeed;

class Services extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id'=>42,
                'operator_id'=>1,
                'service_type_id'=>2,
                'image'=>'',
                'status'=>1
            ],
            [
                'id'=>83,
                'operator_id'=>1,
                'service_type_id'=>2,
                'image'=>'',
                'status'=>1
            ],
            [
                'id'=>47,
                'operator_id'=>3,
                'service_type_id'=>2,
                'image'=>'',
                'status'=>1
            ]
        ];

        $this->table('services')->insert($data)->save();
    }
}
