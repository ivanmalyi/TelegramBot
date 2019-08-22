<?php

declare(strict_types=1);

namespace System\Console\Command\DownloadKeys;

use System\Console\AbstractCommand;
use System\Entity\Component\Billing\Response\DownloadKeysResponse;
use System\Entity\Component\Billing\BillingResponseCode;
use System\Entity\InternalProtocol\ResponseCode;
use System\Kernel\Protocol\AnswerBundle;
use System\Kernel\Protocol\CommandLinePacket;

/**
 * Class DownloadKeysCommand
 * @package System\Console\Command
 */
class DownloadKeysCommand extends AbstractCommand
{
    use DownloadKeysCommandDependenciesTrait;

    /**
     * @param CommandLinePacket $packet
     *
     * @return AnswerBundle
     *
     * @throws \System\Exception\DiException
     */
    public function handle(CommandLinePacket $packet): AnswerBundle
    {
        $response = $this->getBillingComponent()->downloadKeys();

        if ($response->getResult() === BillingResponseCode::SUCCESS_ACTION) {
            $this->saveKeys($response);
            $result = ResponseCode::SUCCESS_ACTION;
        } elseif ($response->getResult() === BillingResponseCode::ACCESS_DENIED_FOR_DOWNLOAD_KEYS) {
            $result = ResponseCode::ACCESS_DENIED_FOR_DOWNLOAD_KEYS;
        } else {
            $result = ResponseCode::UNKNOWN_ERROR;
        }

        return new AnswerBundle(['Result' => $result]);
    }

    /**
     * @param DownloadKeysResponse $downloadKeysResponse
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    private function saveKeys(DownloadKeysResponse $downloadKeysResponse): int
    {
        return $this->getBillingSettingsRepository()->updateKeys(
            $downloadKeysResponse->getPublicKey(),
            $downloadKeysResponse->getPrivateKey()
        );
    }
}