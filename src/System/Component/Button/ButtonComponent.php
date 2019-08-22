<?php

declare(strict_types=1);

namespace System\Component\Button;

use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\Repository\Button;
use System\Exception\EmptyFetchResultException;

/**
 * Class ButtonComponent
 * @package System\Component\Button
 */
class ButtonComponent implements ButtonComponentInterface
{
    use ButtonComponentDependenciesTrait;

    /**
     * @param int $buttonId
     * @param string $localization
     * @param StageMessageVariables|null $variables
     *
     * @return Button
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findButton(int $buttonId, string $localization, ?StageMessageVariables $variables = null): Button
    {
        $button = $this->getButtonsRepository()->findButton($buttonId, $localization);
        $button->setName($this->fillEmoji($button->getName()));
        if ($variables !== null) {
            $button->setName(
                str_replace('{current_phone_number}', $variables->getCurrentPhoneNumber(), $button->getName())
            );
        }

        return $button;
    }

    /**
     * @param string $buttonName
     *
     * @return string
     *
     * @throws \System\Exception\DiException
     */
    private function fillEmoji(string $buttonName): string
    {
        $matches = [];
        $isMatch = preg_match_all('/{{emoji_\\d}}/', $buttonName, $matches);

        if ($isMatch > 0) {
            foreach ($matches[0] as $emojiTemplate) {
                preg_match('/\\d/', $emojiTemplate,$id);
                try {
                    $emoji = $this->getEmojiRepository()->findEmojiById((int)$id[0]);
                    $unicode = $emoji->getUnicode();
                } catch (EmptyFetchResultException $e) {
                    $unicode = '';
                }
                $buttonName = str_replace($emojiTemplate, $unicode, $buttonName);
            }
        }

        return $buttonName;
    }

    /**
     * @param string $message
     * @param string $buttonType
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function findStageByButtonName(string $message, string $buttonType): int
    {
        $text = '';
        $isMatchMessage = preg_match_all("/[а-яА-ЯёЁЇїІіa-zA-Z\s]+/u", $message, $matchesMessage);
        if ($isMatchMessage > 0) {
            $text = mb_strtolower(trim($matchesMessage[0][0]));
        }


        $buttons = $this->getButtonsRepository()->findButtonsByType($buttonType);
        foreach ($buttons as $button) {
            $matchesEmoji = [];
            $buttonName = $button->getName();
            $isMatchEmoji = preg_match_all('/{{emoji_\\d}}/', $buttonName, $matchesEmoji);

            if ($isMatchEmoji > 0) {
                foreach ($matchesEmoji[0] as $emojiTemplate) {
                    $buttonName = str_replace($emojiTemplate, "", $buttonName);
                }
            }

            $buttonName = mb_strtolower(trim($buttonName));
            if ($buttonName == $text) {
                return (int)$button->getValue();
            }
        }

        return 0;
    }

    /**
     * @param string $buttonType
     * @param string $localization
     *
     * @return Button[]
     *
     * @throws \System\Exception\DiException
     */
    public function findButtonsByType(string $buttonType, string $localization): array
    {
        $buttons = $this->getButtonsRepository()->findButtonsByType($buttonType, $localization);

        foreach ($buttons as $button) {
            $button->setName($this->fillEmoji($button->getName()));
        }

        return $buttons;
    }
}