<?php

declare(strict_types=1);

namespace System\Util\MailClient;

/**
 * Interface MailClientInterface
 * @package System\Util\MailClient
 */
interface MailClientInterface
{
    /**
     * Send the given Message like it would be sent in a mail client.
     *
     * All recipients (with the exception of Bcc) will be able to see the other
     * recipients this message was sent to.
     *
     * Recipient/sender data will be retrieved from the Message object.
     *
     * The return value is the number of recipients who were accepted for
     * delivery.
     *
     * @param array $failedRecipients An array of failures by-reference
     *
     * @return int The number of successful recipients. Can be 0 which indicates failure
     */
    public function send(\Swift_Mime_SimpleMessage $message, &$failedRecipients = null);

    /**
     * @return string
     */
    public function getEmailFromAddress(): string;
}
