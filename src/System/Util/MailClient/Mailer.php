<?php

declare(strict_types=1);

namespace System\Util\MailClient;

/**
 * Class Mailer
 * @package System\Util
 */
class Mailer extends \Swift_Mailer implements MailClientInterface
{
    /**
     * @var string
     */
    private $emailFromAddress;

    /**
     * Mailer constructor.
     * @param \Swift_Transport $transport
     * @param string $fromEmail
     */
    public function __construct(\Swift_Transport $transport, string $fromEmail)
    {
        parent::__construct($transport);
        $this->emailFromAddress = $fromEmail;
    }

    /**
     * @return string
     */
    public function getEmailFromAddress() : string
    {
        return $this->emailFromAddress;
    }
}
