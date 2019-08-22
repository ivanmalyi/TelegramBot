<?php

declare(strict_types=1);

namespace System\Facade\LoadCommissions;

use System\Entity\InternalProtocol\ChatBotId;
use System\Entity\InternalProtocol\Currency;
use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Entity\InternalProtocol\Stage;
use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\Repository\Chat;
use System\Entity\Repository\Cheque;
use System\Entity\Repository\ChequeCommission;
use System\Entity\Repository\Commission;
use System\Exception\DiException;
use System\Exception\EmptyFetchResultException;
use System\Exception\Protocol\DatabaseDataNotFoundException;
use System\Facade\TelegramFacadeInterface;
use System\Kernel\Protocol\AnswerMessage;
use System\Util\ChatHistory\ChatHistoryTrait;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class LoadCommissionFacade
 * @package System\Facade\LoadCommission
 */
class LoadCommissionsFacade implements TelegramFacadeInterface
{
    use LoggerReferenceTrait;
    use LoadCommissionsFacadeDependenciesTrait;
    use ChatHistoryTrait;

    /**
     * @param TelegramRequest $request
     * @return AnswerMessage
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    public function process(TelegramRequest $request): AnswerMessage
    {
        $answerMessage = new AnswerMessage($request->getMessage()->getChat()->getId());

        $chat = $this->saveInfoForInteraction($request);
        $cheque = $this->getCheque($chat);

        $commissions = $this->getCommissionsRepository()->findAllByItemIdAndTime(
            $cheque->getItemId(),
            date('H:i:s')
        );
        $this->bindCommissionsToCheque($cheque, $commissions);

        $answerMessage->setMessage(
            $this->prepareCommissionsText($chat, $commissions)
        );
        $answerMessage->setGoToStage(Stage::GET_AMOUNT);
        return $answerMessage;
    }

    /**
     * @param TelegramRequest $telegramRequest
     *
     * @return Chat
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    private function saveInfoForInteraction(TelegramRequest $telegramRequest): Chat
    {
        try {
            $chat = $this->getChatsRepository()->findByProviderChatId(
                $telegramRequest->getMessage()->getChat()->getId(),
                ChatBotId::TELEGRAM
            );
        } catch (EmptyFetchResultException $e) {
            throw new DatabaseDataNotFoundException('Чат не найден');
        }

        $chat->setCurrentStage(Stage::GET_COMMISSIONS);
        $chat->setCurrentSubStage(0);
        $this->getChatsRepository()->updateCurrentInfo($chat);
        $this->saveHistoryByChat($chat);
        return $chat;
    }

    /**
     * @param Chat $chat
     *
     * @return Cheque
     *
     * @throws DatabaseDataNotFoundException
     * @throws DiException
     */
    private function getCheque(Chat $chat): Cheque
    {
        try {
            $cheque = $this->getChequesRepository()->findById($chat->getCurrentChequeId());
            if ($cheque->getStatus() !== Cheque::OK) {
                throw new DatabaseDataNotFoundException(
                    'Cheque must have 0 status but '.$cheque->getStatus()
                );
            }
            return $cheque;
        } catch (EmptyFetchResultException $e) {
            throw new DatabaseDataNotFoundException('A cheque  '.$chat->getCurrentChequeId().' not found');
        }
    }

    /**
     * @param Cheque $cheque
     * @param Commission[] $commissions
     *
     * @throws DiException
     */
    private function bindCommissionsToCheque(Cheque $cheque, array $commissions): void
    {
        foreach ($commissions as $commission) {
            $this->getChequesCommissionsRepository()->create(
                new ChequeCommission($cheque->getId(), $commission->getId(), $commission->getItemId())
            );
        }
    }

    /**
     * @param Chat $chat
     * @param Commission[] $commissions
     *
     * @return string
     *
     * @throws DiException
     */
    private function prepareCommissionsText(Chat $chat, array $commissions): string
    {
        if (!empty($commissions)) {
            $text = [$this->findMessage($chat, LoadCommissionsSubStage::TITLE)];

            foreach ($commissions as $commission) {
                if ($commission->getFromAmount() === 0 and $commission->getToAmount() > 0) {
                    $subStage = LoadCommissionsSubStage::FIRST_RULE;
                } elseif ($commission->getFromAmount() > 0 and $commission->getToAmount() === 0) {
                    $subStage = LoadCommissionsSubStage::LAST_RULE;
                } elseif ($commission->getFromAmount() === 0 and $commission->getToAmount() === 0) {
                    $subStage = LoadCommissionsSubStage::ANY_AMOUNT;
                } else {
                    $subStage = LoadCommissionsSubStage::COMMON_RULE;
                }
                $rule = $this->findMessage($chat, $subStage, $commission);

                if ($commission->getAlgorithm() === 0 ) {
                    $rule .= ' грн';
                } else {
                    $rule .= ' %';
                    if ($commission->getMinAmount() > 0) {
                        $rule .= $this->findMessage(
                            $chat,
                            LoadCommissionsSubStage::MIN_AMOUNT,
                            $commission
                        );
                    }
                    if ($commission->getMaxAmount() > 0) {
                        $rule .= $this->findMessage(
                            $chat,
                            LoadCommissionsSubStage::MAX_AMOUNT,
                            $commission
                        );
                    }
                }
                $text[] = $rule;
            }
            return implode("\n", $text);
        }
        return '';
    }

    /**
     * @param Chat $chat
     * @param int $subStage
     * @param Commission|null $commission
     *
     * @return string
     *
     * @throws DiException
     */
    private function findMessage(Chat $chat, int $subStage, ?Commission $commission = null): string
    {
        try {
            $stageMessage = $this->getStagesMessagesRepository()->findMessage(
                $chat->getCurrentStage(),
                $subStage,
                $chat->getCurrentLocalization()
            );

            if ($commission !== null) {
                $stageMessageVariables = new StageMessageVariables();
                $stageMessageVariables->setAmount(Currency::kopeckToUah($commission->getAmount()));
                $stageMessageVariables->setFromAmount(Currency::kopeckToUah($commission->getFromAmount()));
                $stageMessageVariables->setToAmount(Currency::kopeckToUah($commission->getToAmount()));
                $stageMessageVariables->setMinAmount(Currency::kopeckToUah($commission->getMinAmount()));
                $stageMessageVariables->setMaxAmount(Currency::kopeckToUah($commission->getMaxAmount()));

                return $this->getMessageProcessingComponent()->fillMessage($stageMessageVariables, $stageMessage);
            }
            return $stageMessage->getMessage();
        } catch (EmptyFetchResultException $e) {
            $this->getLogger()->debug(
                'StageMessage not found for stage '.$chat->getCurrentStage().' sub stage '.$subStage
            );
            return 'Увы но я не знаю что сказать, обучи меня пожалуйста!';
        }
    }
}