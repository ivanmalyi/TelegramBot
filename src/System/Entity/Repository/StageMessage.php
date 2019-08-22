<?php

declare(strict_types=1);

namespace System\Entity\Repository;

/**
 * Class StageMessage
 * @package System\Entity\Repository
 */
class StageMessage
{
    /**
     * @var int
     */
    private $stage;

    /**
     * @var int
     */
    private $subStage;

    /**
     * @var string
     */
    private $localization;

    /**
     * @var string
     */
    private $message;

    /**
     * @var int
     */
    private $id;

    /**
     * StageMessage constructor.
     * @param int $stage
     * @param int $subStage
     * @param string $localization
     * @param string $message
     * @param int $id
     */
    public function __construct(int $stage, int $subStage, string $localization, string $message, int $id = 0)
    {
        $this->stage = $stage;
        $this->subStage = $subStage;
        $this->localization = $localization;
        $this->message = $message;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getStage(): int
    {
        return $this->stage;
    }

    /**
     * @return int
     */
    public function getSubStage(): int
    {
        return $this->subStage;
    }

    /**
     * @return string
     */
    public function getLocalization(): string
    {
        return $this->localization;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
