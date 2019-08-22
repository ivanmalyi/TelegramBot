<?php

declare(strict_types=1);

namespace System\Entity\Repository;


/**
 * Class Talk
 * @package System\Entity\Repository
 */
class Talk
{
    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $question;

    /**
     * @var string
     */
    private $answer;

    /**
     * @var int
     */
    private $id;

    /**
     * Talk constructor.
     * @param int $status
     * @param string $question
     * @param string $answer
     * @param int $id
     */
    public function __construct(int $status, string $question, string $answer, int $id = 0)
    {
        $this->status = $status;
        $this->question = $question;
        $this->answer = $answer;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->answer;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}