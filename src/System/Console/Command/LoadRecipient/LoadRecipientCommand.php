<?php

declare(strict_types=1);

namespace System\Console\Command\LoadRecipient;

use System\Console\AbstractCommand;
use System\Entity\Component\Billing\BillingResponseCode;
use System\Entity\InternalProtocol\ResponseCode;
use System\Entity\Repository\Recipient;
use System\Entity\Repository\RecipientTemplate;
use System\Kernel\Protocol\AnswerBundle;
use System\Kernel\Protocol\CommandLinePacket;

/**
 * Class LoadRecipientCommand
 * @package System\Console\Command\LoadRecipient
 */
class LoadRecipientCommand extends AbstractCommand
{
    use LoadRecipientCommandDependenciesTrait;

    /**
     * @param CommandLinePacket $packet
     * @return AnswerBundle
     *
     * @throws \System\Exception\DiException
     */
    public function handle(CommandLinePacket $packet): AnswerBundle
    {
        $response = $this->getBillingComponent()->loadRecipient();
        if ($response->getResult() !== BillingResponseCode::SUCCESS_ACTION) {
            return new AnswerBundle(['Result' => ResponseCode::UNKNOWN_ERROR]);
        }

        $this->getRecipientsRepository()->deleteAll();
        $this->getRecipientsRepository()->saveAll($response->getRecipients());

        $this->getRecipientsTemplateRepository()->deleteAll();
        foreach ($response->getTemplate() as $template) {
            $this->getRecipientsTemplateRepository()->save(new RecipientTemplate(
                Recipient::TEMPLATE_ID,
                $template->getLanguage(),
                $template->getText()
            ));
        }

        return new AnswerBundle(['Result' => ResponseCode::SUCCESS_ACTION]);
    }
}
