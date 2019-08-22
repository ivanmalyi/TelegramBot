<?php


use Phinx\Seed\AbstractSeed;

class Emoji extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'unicode' => json_encode("\xF0\x9F\x93\xB1"),
                'description'=> "mobile phone"
            ],
            [
                'id' => 2,
                'unicode' => json_encode("\xF0\x9F\x94\x83"),
                'description'=> "clockwise downwards and upwards open circle arrows"
            ],
            [
                'id' => 3,
                'unicode' => json_encode("\xF0\x9F\x93\x8B"),
                'description'=> "clipboard"
            ],
            [
                'id' => 4,
                'unicode' => json_encode("\xF0\x9F\x92\xB3"),
                'description'=> "credit card"
            ],
            [
                'id' => 5,
                'unicode' => json_encode("\xF0\x9F\x94\x8E"),
                'description'=> "right-pointing magnifying glass"
            ],
            [
                'id' => 6,
                'unicode' => json_encode("	\xE2\xAC\x85"),
                'description'=> "leftwards black arrow"
            ],
            [
                'id' => 7,
                'unicode' => json_encode("\xE2\x9E\xA1"),
                'description'=> "black rightwards arrow"
            ],
            [
                'id' => 8,
                'unicode' => json_encode("\xF0\x9F\x94\x90"),
                'description'=> "closed lock with key"
            ],
            [
                'id' => 9,
                'unicode' => json_encode("\xE2\x9D\x8C"),
                'description'=> "cross mark"
            ],
        ];

        $this->table('emoji')->insert($data)->save();
    }
}
