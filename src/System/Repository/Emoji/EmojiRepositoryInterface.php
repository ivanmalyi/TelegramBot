<?php

declare(strict_types=1);

namespace System\Repository\Emoji;


use System\Entity\Repository\Emoji;

/**
 * Interface EmojiRepositoryInterface
 * @package System\Repository\Emoji
 */
interface EmojiRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Emoji
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findEmojiById(int $id): Emoji;
}