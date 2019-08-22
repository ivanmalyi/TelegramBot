<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol\Request;

use System\Kernel\Protocol\RequestBundle;
use System\Util\Validation\ArrayReaderAdapter;
use System\Util\Validation\NotEmptyString;

/**
 * Class UtmRequest
 * @package System\Entity\InternalProtocol\Request
 */
class UtmRequest extends Request
{
    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $medium;

    /**
     * @var string
     */
    private $campaign;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $term;

    /**
     * UtmRequest constructor.
     * @param string $command
     * @param string $source
     * @param string $medium
     * @param string $campaign
     * @param string $content
     * @param string $term
     */
    public function __construct(
        string $command,
        string $source,
        string $medium,
        string $campaign,
        string $content,
        string $term
    )
    {
        parent::__construct($command);
        $this->source = $source;
        $this->medium = $medium;
        $this->campaign = $campaign;
        $this->content = $content;
        $this->term = $term;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getMedium(): string
    {
        return $this->medium;
    }

    /**
     * @return string
     */
    public function getCampaign(): string
    {
        return $this->campaign;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getTerm(): string
    {
        return $this->term;
    }

    /**
     * @param RequestBundle $requestBundle
     *
     * @return UtmRequest
     *
     * @throws \System\Exception\Protocol\MissingArgumentException
     * @throws \System\Exception\Protocol\ValidateArgumentException
     */
    public static function validation(RequestBundle $requestBundle): self
    {
        $reader = new ArrayReaderAdapter($requestBundle->getParams());

        $urlParams = $requestBundle->getUrlParams();
        $urlReader = new ArrayReaderAdapter($urlParams);

        $utmContent = isset($urlParams['utm_content']) ? $urlReader->readWith(new NotEmptyString(), 'utm_content') : '';
        $utmTerm = isset($urlParams['utm_term']) ? $urlReader->readWith(new NotEmptyString(), 'utm_term') : '';

        return new self(
            $reader->readWith(new NotEmptyString(), 'Command'),
            $urlReader->readWith(new NotEmptyString(), 'utm_source'),
            $urlReader->readWith(new NotEmptyString(), 'utm_medium'),
            $urlReader->readWith(new NotEmptyString(), 'utm_campaign'),
            $utmContent,
            $utmTerm
        );
    }
}
