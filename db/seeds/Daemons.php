<?php

use Phinx\Seed\AbstractSeed;

class Daemons extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'pay',
                'status' => 0
            ],
            [
                'id' => 2,
                'name' => 'check',
                'status' => 0
            ]
        ];

        $this->table('daemons')->insert($data)->save();
    }
}
