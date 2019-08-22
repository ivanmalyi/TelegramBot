<?php

declare(strict_types=1);

namespace System\Repository\Talk;
use System\Entity\Repository\Talk;


/**
 * Interface TalkRepositoryInterface
 * @package System\Repository\Talk
 */
interface TalkRepositoryInterface
{

    /**
     * @param int $id
     *
     * @return Talk[]
     */
    public function findTalks(int $id = 0): array;

    /**
     * @param string $question
     *
     * @return int
     */
    public function saveQuestionWithoutAnswer(string $question): int;
}