<?php

declare(strict_types=1);

namespace System\Component\MessageProcessing;


use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\Repository\StageMessage;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;

/**
 * Class MessageProcessingComponent
 * @package System\Component\MessageProcessing
 */
class MessageProcessingComponent implements MessageProcessingComponentInterface
{
   use MessageProcessingComponentDependenciesTrait;

    /**
     * @param StageMessageVariables $variables
     * @param StageMessage $stageMessage
     *
     * @return string
     *
     * @throws \System\Exception\DiException
     */
    public function fillMessage(StageMessageVariables $variables, StageMessage $stageMessage): string
    {
        $message = str_replace('{fio}', $variables->getFio(), $stageMessage->getMessage());
        $message = str_replace('{account}', $variables->getAccount(), $message);
        $message = str_replace('{billingChequeId}', $variables->getBillingChequeId(), $message);
        $message = str_replace('{from_amount}', $variables->getFromAmount(), $message);
        $message = str_replace('{to_amount}', $variables->getToAmount(), $message);
        $message = str_replace('{min_amount}', $variables->getMinAmount(), $message);
        $message = str_replace('{max_amount}', $variables->getMaxAmount(), $message);
        $message = str_replace('{total_amount}', $variables->getTotalAmount(), $message);
        $message = str_replace('{commission}', $variables->getCommission(), $message);
        $message = str_replace('{amount}', $variables->getAmount(), $message);
        $message = str_replace('{current_phone_number}', '', $message);

        return $this->fillEmoji($message);
    }

    /**
     * @param string $message
     *
     * @return string
     *
     * @throws \System\Exception\DiException
     */
    private function fillEmoji(string $message): string
    {
        $matches = [];
        $isMatch = preg_match_all('/{{emoji_\\d+}}/', $message, $matches);

        if ($isMatch > 0) {
            foreach ($matches[0] as $emojiTemplate) {
                preg_match('/\\d+/', $emojiTemplate,$id);
                try {
                    $emoji = $this->getEmojiRepository()->findEmojiById((int)$id[0]);
                    $unicode = $emoji->getUnicode();
                } catch (EmptyFetchResultException $e) {
                    $unicode = '';
                }
                $message = str_replace($emojiTemplate, $unicode, $message);
            }
        }

        return $message;
    }
}