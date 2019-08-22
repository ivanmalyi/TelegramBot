<?php

declare(strict_types=1);

namespace System\Component\Button;


use System\Exception\DiException;
use System\Repository\Buttons\ButtonsRepositoryInterface;
use System\Repository\Emoji\EmojiRepositoryInterface;

trait ButtonComponentDependenciesTrait
{
    /**
     * @var EmojiRepositoryInterface
     */
    private $emojiRepository;

    /**
     * @var ButtonsRepositoryInterface
     */
    private $buttonsRepository;

    /**
     * @return EmojiRepositoryInterface
     *
     * @throws DiException
     */
    public function getEmojiRepository(): EmojiRepositoryInterface
    {
        if (null === $this->emojiRepository) {
            throw new DiException('EmojiRepository');
        }
        return $this->emojiRepository;
    }

    /**
     * @param EmojiRepositoryInterface $emojiRepository
     */
    public function setEmojiRepository(EmojiRepositoryInterface $emojiRepository): void
    {
        $this->emojiRepository = $emojiRepository;
    }


    /**
     * @return ButtonsRepositoryInterface
     * @throws DiException
     */
    public function getButtonsRepository(): ButtonsRepositoryInterface
    {
        if (null === $this->buttonsRepository) {
            throw new DiException('ButtonsRepository');
        }
        return $this->buttonsRepository;
    }

    /**
     * @param ButtonsRepositoryInterface $buttonsRepository
     */
    public function setButtonsRepository(ButtonsRepositoryInterface $buttonsRepository): void
    {
        $this->buttonsRepository = $buttonsRepository;
    }
}