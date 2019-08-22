<?php

declare(strict_types=1);

namespace System\Component\MessageProcessing;
use System\Exception\DiException;
use System\Repository\Emoji\EmojiRepositoryInterface;


/**
 * Trait MessageProcessingComponentDependenciesTrait
 * @package System\Component\MessageProcessing
 */
trait MessageProcessingComponentDependenciesTrait
{
    /**
     * @var EmojiRepositoryInterface
     */
    private $emojiRepository;

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
}