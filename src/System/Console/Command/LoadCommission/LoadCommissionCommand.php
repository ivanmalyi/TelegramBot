<?php

declare(strict_types=1);

namespace System\Console\Command\LoadCommission;

use System\Console\AbstractCommand;
use System\Entity\Component\Billing\Response\LoadCommissionResponse;
use System\Entity\Component\FlashNoticeTransport;
use System\Entity\InternalProtocol\ResponseCode;
use System\Kernel\Protocol\AnswerBundle;
use System\Kernel\Protocol\CommandLinePacket;

/**
 * Class LoadCommissionCommand
 * @package System\Console\Command
 */
class LoadCommissionCommand extends AbstractCommand
{
    use LoadCommissionCommandDependenciesTrait;

    /**
     * @param CommandLinePacket $packet
     * @return AnswerBundle
     * @throws \ReflectionException
     * @throws \System\Exception\DiException
     */
    public function handle(CommandLinePacket $packet): AnswerBundle
    {
        $loadCommissionResponse = $this->getBillingComponent()->loadCommission();

        if ($loadCommissionResponse->getResult() == ResponseCode::SUCCESS_ACTION) {
            $this->saveCommissions($loadCommissionResponse);
            $answerBundle = new AnswerBundle(['Result' => ResponseCode::SUCCESS_ACTION]);
        } else {
            $this->getFlashNotice()->sendMessage(
                strtolower((new \ReflectionClass($this))->getShortName()).
                "\nCommissions not loaded\n result: ".$loadCommissionResponse->getResult(),
                FlashNoticeTransport::TELEGRAM
            );

            $answerBundle = new AnswerBundle(['Result' => ResponseCode::UNKNOWN_ERROR]);
        }

        return $answerBundle;
    }

    /**
     * @param LoadCommissionResponse $loadCommissionResponse
     * @throws \System\Exception\DiException
     */
    private function saveCommissions(LoadCommissionResponse $loadCommissionResponse): void
    {
        $this->getCommissionsRepository()->clearCommissions();
        $this->getCommissionsRepository()->saveCommissions($loadCommissionResponse->getCommissions());
    }
}