<?php


use Phinx\Seed\AbstractSeed;

class Sections extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id'=>1,
                'name_ua'=>'Мобільний зв’язок',
                'name_ru'=>'Мобильная связь',
                'name_en'=>'Mobile connection',
            ]
        ];

        $this->table('sections')->insert($data)->save();
    }
}
