<?php


use Phinx\Seed\AbstractSeed;

class ServicesLocalization extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id'=>1,
                'service_id'=>42,
                'localization'=>'UA',
                'name'=>'На будь-яку суму Київстар'
            ],
            [
                'id'=>2,
                'service_id'=>42,
                'localization'=>'RU',
                'name'=>'На любую сумму Киевстар'
            ],
            [
                'id'=>3,
                'service_id'=>47,
                'localization'=>'UA',
                'name'=>'На будь-яку суму МТС'
            ],
            [
                'id'=>4,
                'service_id'=>47,
                'localization'=>'RU',
                'name'=>'На любую сумму МТС'
            ],
        ];

        $this->table('services_localization')->insert($data)->save();
    }
}
