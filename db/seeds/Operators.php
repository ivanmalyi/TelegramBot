<?php


use Phinx\Seed\AbstractSeed;

class Operators extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id'=>1,
                'section_id'=>1,
                'image'=>'',
                'status'=>1
            ]
        ];

        $this->table('operators')->insert($data)->save();
    }
}
