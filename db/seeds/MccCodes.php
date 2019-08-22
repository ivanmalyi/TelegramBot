<?php


use Phinx\Seed\AbstractSeed;

class MccCodes extends AbstractSeed
{
    public function run()
    {
        $data = [
            ['id' => 1, 'name' => 'Mobile'],
            ['id' => 2, 'name' => 'Communal'],
            ['id' => 3, 'name' => 'Internet'],
            ['id' => 4, 'name' => 'TV'],
            ['id' => 5, 'name' => 'Budget'],
            ['id' => 7, 'name' => 'Games'],
            ['id' => 8, 'name' => 'Taxi'],
            ['id' => 9, 'name' => 'E-commerce'],
            ['id' => 10, 'name' => 'Other'],
            ['id' => 11, 'name' => 'Kasta']
        ];

        $this->table('mcc_codes')->insert($data)->save();
    }
}
