<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;

use System\Entity\Component\Billing\LocalizationData;
use System\Entity\Repository\Recipient;

/**
 * Class LoadRecipientResponse
 * @package System\Entity\Component\Billing\Response\LoadRecipient
 */
class LoadRecipientResponse extends Response
{
    /**
     * @var LocalizationData[]
     */
    private $template;

    /**
     * @var Recipient[]
     */
    private $recipients;

    /**
     * LoadRecipientResponse constructor.
     * @param int $result
     * @param LocalizationData[] $template
     * @param Recipient[] $recipients
     * @param string $time
     */
    public function __construct(int $result, array $template, array $recipients, string $time)
    {
        parent::__construct($result, $time);
        $this->template = $template;
        $this->recipients = $recipients;
    }

    /**
     * @return LocalizationData[]
     */
    public function getTemplate(): array
    {
        return $this->template;
    }

    /**
     * @return Recipient[]
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * @param int $result
     * @return LoadRecipientResponse
     */
    public static function buildWhenError(int $result): self
    {
        return new self($result, [], [], date('Y-m-d H:i:s'));
    }
}
