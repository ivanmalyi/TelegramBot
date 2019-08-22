<?php

declare(strict_types=1);

namespace System\Repository\Talk;


use System\Entity\Repository\Talk;
use System\Repository\AbstractPdoRepository;

/**
 * Class TalkRepository
 * @package System\Repository\Talk
 */
class TalkRepository extends AbstractPdoRepository implements TalkRepositoryInterface
{

    /**
     * @param int $id
     *
     * @return Talk[]
     */
    public function findTalks(int $id = 0): array
    {
        $sql = 'select id, status, question, answer
          from talk
           where status = 1 and id > :id order by id asc limit 50000';

        $rows = $this->execAssoc($sql, ['id'=>$id]);

        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->inflate($row);
        }

        return $result;
    }

    /**
     * @param array $row
     *
     * @return Talk
     */
    private function inflate(array $row): Talk
    {
        return new Talk((int)$row['status'], $row['question'], $row['answer'], (int)$row['id']);
    }

    /**
     * @param string $question
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function saveQuestionWithoutAnswer(string $question): int
    {
        $sql = 'insert into talk (question) value (:question)';

        return $this->insert($sql, ['question'=>$question]);
    }
}