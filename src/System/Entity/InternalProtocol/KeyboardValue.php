<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol;


/**
 * Class KeyboardValue
 * @package System\Entity\InternalProtocol
 */
/**
 * Class KeyboardValue
 * @package System\Entity\InternalProtocol
 */
class KeyboardValue
{
    /**
     * @var string
     */
    private $buttonText;

    /**
     * @var int
     */
    private $buttonId;

    /**
     * @var string
     */
    private $keyboardAction;

    /**
     * @var string
     */
    private $paginationBackText;

    /**
     * @var string
     */
    private $paginationForwardText;

    /**
     * @var string
     */
    private $paginationAction;

    /**
     * KeyboardValue constructor.
     * @param string $buttonText
     * @param int $buttonId
     * @param string $keyboardAction
     * @param string $paginationBackText
     * @param string $paginationForwardText
     * @param string $paginationAction
     */
    public function __construct(
        string $buttonText,
        int $buttonId,
        string $keyboardAction,
        string $paginationBackText = '',
        string $paginationForwardText = '',
        string $paginationAction = ''
    )
    {
        $this->buttonText = $buttonText;
        $this->buttonId = $buttonId;
        $this->keyboardAction = $keyboardAction;
        $this->paginationBackText = $paginationBackText;
        $this->paginationForwardText = $paginationForwardText;
        $this->paginationAction = $paginationAction;
    }

    /**
     * @return string
     */
    public function getButtonText(): string
    {
        return $this->buttonText;
    }

    /**
     * @return int
     */
    public function getButtonId(): int
    {
        return $this->buttonId;
    }

    /**
     * @return string
     */
    public function getKeyboardAction(): string
    {
        return $this->keyboardAction;
    }

    /**
     * @return string
     */
    public function getPaginationBackText(): string
    {
        return $this->paginationBackText;
    }

    /**
     * @return string
     */
    public function getPaginationForwardText(): string
    {
        return $this->paginationForwardText;
    }

    /**
     * @return string
     */
    public function getPaginationAction(): string
    {
        return $this->paginationAction;
    }
}