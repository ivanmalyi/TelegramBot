<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol\Request\Telegram;
use System\Util\Validation\AnyString;
use System\Util\Validation\ArrayReaderAdapter;
use System\Util\Validation\BooleanArgument;
use System\Util\Validation\NotEmptyString;
use System\Util\Validation\PositiveIntegerOrZero;

/**
 * Class CallbackData
 * @package System\Entity\InternalProtocol\Request\Telegram
 */
class CallbackData
{
    /**
     * @var string
     */
    private $typeKeyboardAction;

    /**
     * @var int
     */
    private $buttonId;

    /**
     * @var bool
     */
    private $isPagination;

    /**
     * @var int
     */
    private $paginationButtonId;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $flag;

    /**
     * CallbackData constructor.
     * @param string $typeKeyboardAction
     * @param int $buttonId
     * @param bool $isPagination
     * @param int $paginationButtonId
     * @param string $token
     * @param string $flag
     */
    public function __construct(
        string $typeKeyboardAction,
        int $buttonId,
        bool $isPagination,
        int $paginationButtonId,
        string $token,
        string $flag
    )
    {
        $this->typeKeyboardAction = $typeKeyboardAction;
        $this->buttonId = $buttonId;
        $this->isPagination = $isPagination;
        $this->paginationButtonId = $paginationButtonId;
        $this->token = $token;
        $this->flag = $flag;
    }

    /**
     * @return string
     */
    public function getTypeKeyboardAction(): string
    {
        return $this->typeKeyboardAction;
    }

    /**
     * @return int
     */
    public function getButtonId(): int
    {
        return $this->buttonId;
    }

    /**
     * @return bool
     */
    public function isPagination(): bool
    {
        return $this->isPagination;
    }

    /**
     * @return int
     */
    public function getPaginationButtonId(): int
    {
        return $this->paginationButtonId;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getFlag(): string
    {
        return $this->flag;
    }

    /**
     * @param array $data
     * @return CallbackData
     * @throws \System\Exception\Protocol\MissingArgumentException
     * @throws \System\Exception\Protocol\ValidateArgumentException
     */
    public static function validation(array $data): CallbackData
    {
        $reader = new ArrayReaderAdapter($data);

        return new CallbackData(
            $reader->readWith(new NotEmptyString(), 'KbAction'),
            $reader->readWith(new PositiveIntegerOrZero(), 'BtnId'),
            isset($data['Pg']) ? $reader->readWith(new BooleanArgument(), 'Pg') : false,
            isset($data['pgBtnId']) ? $reader->readWith(new PositiveIntegerOrZero(), 'pgBtnId') : 0,
            isset($data['token']) ? $reader->readWith(new AnyString(), 'token') : '',
            isset($data['Flag']) ? $reader->readWith(new AnyString(), 'Flag') : ''
        );
    }
}
