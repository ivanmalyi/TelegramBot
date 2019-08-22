<?php

declare(strict_types=1);

namespace System\Console\Command\LoadPaymentSystems;

use System\Console\AbstractCommand;
use System\Entity\Component\Billing\BillingResponseCode;
use System\Entity\InternalProtocol\ResponseCode;
use System\Kernel\Protocol\AnswerBundle;
use System\Kernel\Protocol\CommandLinePacket;

/**
 * Class LoadPaymentSystemsCommand
 * @package System\Console\Command\LoadPaymentSystems
 */
class LoadPaymentSystemsCommand extends AbstractCommand
{
    use LoadPaymentSystemsCommandDependenciesTrait;

    /**
     * @param CommandLinePacket $packet
     *
     * @return AnswerBundle
     *
     * @throws \System\Exception\DiException
     */
    public function handle(CommandLinePacket $packet): AnswerBundle
    {
        $response = $this->getBillingComponent()->loadPaymentSystems();

        if ($response->getResult() !== BillingResponseCode::SUCCESS_ACTION) {
            return new AnswerBundle(['Result' => ResponseCode::UNKNOWN_ERROR]);
        }

        $this->getPaymentSystemsRepository()->deleteAll();
        $this->getPaymentSystemsRepository()->saveAll($response->getPaymentSystems());

        $this->getPaymentSystemsHeadersLocalizationRepository()->deleteAll();
        $this->getPaymentSystemsHeadersLocalizationRepository()->saveAll(
            $response->getPaymentSystemHeaderLocalizations()
        );

        return new AnswerBundle(['Result' => ResponseCode::SUCCESS_ACTION]);
    }
}
