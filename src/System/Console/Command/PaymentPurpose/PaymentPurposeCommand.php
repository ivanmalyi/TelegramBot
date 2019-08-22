<?php

declare(strict_types=1);

namespace System\Console\Command\PaymentPurpose;


use System\Console\AbstractCommand;
use System\Entity\Component\FlashNoticeTransport;
use System\Entity\InternalProtocol\ResponseCode;
use System\Kernel\Protocol\AnswerBundle;
use System\Kernel\Protocol\CommandLinePacket;

/**
 * Class PaymentPurposeCommand
 * @package System\Console\Command\PaymentPurpose
 */
class PaymentPurposeCommand  extends AbstractCommand
{
    use PaymentPurposeCommandDependenciesTrait;
    /**
     * @param CommandLinePacket $packet
     * @return AnswerBundle
     * @throws \ReflectionException
     * @throws \System\Exception\DiException
     */
    public function handle(CommandLinePacket $packet): AnswerBundle
    {
        $paymentPurpose = $this->getBillingComponent()->paymentPurpose();

        if ($paymentPurpose->getResult() == ResponseCode::SUCCESS_ACTION) {
            $this->getPaymentsPurposeRepository()->clearTable();
            $this->getPaymentsPurposeRepository()->savePaymentsPurpose($paymentPurpose->getPaymentsPurpose());
            $answerBundle = new AnswerBundle(['Result' => ResponseCode::SUCCESS_ACTION]);
        } else {
            $this->getFlashNotice()->sendMessage(
                strtolower((new \ReflectionClass($this))->getShortName()).
                "\nPayments purpose not loaded\n result: ".$paymentPurpose->getResult(),
                FlashNoticeTransport::TELEGRAM
            );

            $answerBundle = new AnswerBundle(['Result' => ResponseCode::UNKNOWN_ERROR]);
        }

        return $answerBundle;
    }
}