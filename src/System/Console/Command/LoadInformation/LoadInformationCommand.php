<?php

declare(strict_types=1);

namespace System\Console\Command\LoadInformation;


use System\Console\AbstractCommand;
use System\Entity\Component\FlashNoticeTransport;
use System\Entity\InternalProtocol\ResponseCode;
use System\Kernel\Protocol\AnswerBundle;
use System\Kernel\Protocol\CommandLinePacket;

/**
 * Class LoadInformationCommand
 * @package System\Console\Command\LoadInformation
 */
class LoadInformationCommand  extends AbstractCommand
{
    use LoadInformationCommandDependenciesTrait;

    /**
     * @param CommandLinePacket $packet
     *
     * @return AnswerBundle
     *
     * @throws \ReflectionException
     * @throws \System\Exception\DiException
     */
    public function handle(CommandLinePacket $packet): AnswerBundle
    {
        $loadInformationResponse = $this->getBillingComponent()->loadInformation();

        if ($loadInformationResponse->getResult() == ResponseCode::SUCCESS_ACTION) {
            $this->getPointsInfoRepository()->deleteAll();
            $this->getPointsInfoRepository()->savePointInfo($loadInformationResponse);
            $answerBundle = new AnswerBundle(['Result' => ResponseCode::SUCCESS_ACTION]);
        } else {
            $this->getFlashNotice()->sendMessage(
                strtolower((new \ReflectionClass($this))->getShortName()).
                "\nInformation not loaded\n result: ".$loadInformationResponse->getResult(),
                FlashNoticeTransport::TELEGRAM
            );

            $answerBundle = new AnswerBundle(['Result' => ResponseCode::UNKNOWN_ERROR]);
        }

        return $answerBundle;
    }
}