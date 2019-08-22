<?php


use Phinx\Seed\AbstractSeed;

class OperatorsLocalization extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id'=>1,
                'operator_id'=>1,
                'localization'=>'UA',
                'name'=>'Київстар',
                'description'=>'Плата за послуги мобільного зв`язку оператора Київстар по всій території України'
            ],
            [
                'id'=>2,
                'operator_id'=>1,
                'localization'=>'RU',
                'name'=>'Киевстар',
                'description'=>'Оплата за услуги мобильной связи оператора Киевстар оп всей территории Украины'
            ]
        ];

        $this->table('operators_localization')->insert($data)->save();
    }
}
