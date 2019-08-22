<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol\Request\Telegram;

use System\Entity\InternalProtocol\Request\Request;
use System\Kernel\Protocol\RequestBundle;
use System\Util\Validation\ArrayReaderAdapter;
use System\Util\Validation\NotEmptyString;

/**
 * Class CallbackRequest
 * @package System\Entity\InternalProtocol\Request\Telegram
 */
class CallbackRequest extends Request
{
    /**
     * @var string
     */
    private $guid;

    /**
     * CallbackRequest constructor.
     * @param string $command
     * @param string $guid
     */
    public function __construct(string $command, string $guid)
    {
        parent::__construct($command);
        $this->guid = $guid;
    }

    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }

    /**
     * @param RequestBundle $requestBundle
     * @return self
     * @throws \System\Exception\Protocol\MissingArgumentException
     * @throws \System\Exception\Protocol\ValidateArgumentException
     */
    public static function validation(RequestBundle $requestBundle): self
    {
        $reader = new ArrayReaderAdapter($requestBundle->getParams());
        $urlReader = new ArrayReaderAdapter($requestBundle->getUrlParams());

        return new self(
            $reader->readWith(new NotEmptyString(), 'Command'),
            $urlReader->readWith(new NotEmptyString(), 'guid')
        );
    }
}
