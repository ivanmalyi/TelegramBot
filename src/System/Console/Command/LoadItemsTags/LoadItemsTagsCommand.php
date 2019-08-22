<?php

declare(strict_types=1);

namespace System\Console\Command\LoadItemsTags;


use System\Console\AbstractCommand;
use System\Entity\Component\FlashNoticeTransport;
use System\Entity\InternalProtocol\ResponseCode;
use System\Entity\Repository\ItemTag;
use System\Kernel\Protocol\AnswerBundle;
use System\Kernel\Protocol\CommandLinePacket;

/**
 * Class LoadItemsTagsCommand
 * @package System\Console\Command\LoadItemsTags
 */
class LoadItemsTagsCommand extends AbstractCommand
{
    use LoadItemsTagsCommandDependenciesTrait;

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
        $itemsTagsResponse = $this->getBillingComponent()->loadItemsTags();

        if ($itemsTagsResponse->getResult() == ResponseCode::SUCCESS_ACTION) {
            $this->saveItemsTags($itemsTagsResponse->getItemsTags());
            $answerBundle = new AnswerBundle(['Result' => ResponseCode::SUCCESS_ACTION]);
        } else {
            $this->getFlashNotice()->sendMessage(
                strtolower((new \ReflectionClass($this))->getShortName()).
                "\nTags not loaded\n result: ".$itemsTagsResponse->getResult(),
                FlashNoticeTransport::TELEGRAM
            );

            $answerBundle = new AnswerBundle(['Result' => ResponseCode::UNKNOWN_ERROR]);
        }

        return $answerBundle;
    }

    /**
     * @param ItemTag[] $itemsTags
     *
     * @throws \System\Exception\DiException
     */
    private function saveItemsTags(array $itemsTags): void
    {
        $this->getItemsTagsRepository()->clearItemsTags();
        $this->getItemsTagsRepository()->saveItemsTags($itemsTags);
    }
}