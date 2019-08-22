<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;

/**
 * Class QuestionnaireQuestion
 * @package System\Entity\Component\Billing\Response
 */
class QuestionnaireQuestion
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $question;

    /**
     * @var int
     */
    private $type;

    /**
     * QuestionnaireQuestion constructor.
     * @param int $id
     * @param string $question
     * @param int $type
     */
    public function __construct(int $id, string $question, int $type)
    {
        $this->id = $id;
        $this->question = $question;
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }
}
