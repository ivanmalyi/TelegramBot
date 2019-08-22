<?php

declare(strict_types=1);

namespace System\Repository\Emoji;


use System\Entity\Repository\Emoji;
use System\Repository\AbstractPdoRepository;

/**
 * Class EmojiRepository
 * @package System\Repository\Emoji
 */
class EmojiRepository extends AbstractPdoRepository implements EmojiRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Emoji
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findEmojiById(int $id): Emoji
    {
        $sql = 'select id, unicode, description 
                from emoji
                where id = :id';

        $row = $this->execAssocOne($sql, ['id' => $id]);

        return $this->inflate($row);
    }

    /**
     * @param array $row
     *
     * @return Emoji
     */
    private function inflate(array $row): Emoji
    {
        return new Emoji(
            json_decode($row["unicode"]),
            $row["description"],
            (int)$row["id"]
        );
    }
}