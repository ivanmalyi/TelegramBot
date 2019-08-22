<?php

declare(strict_types=1);

namespace System\Component\PayBot;


use Longman\TelegramBot\Entities\InlineKeyboardButton;
use Longman\TelegramBot\Entities\KeyboardButton;
use System\Entity\Component\Billing\Response\GetPaymentPageResponse;
use System\Entity\Component\Billing\Response\UserCard;
use System\Entity\InternalProtocol\KeyboardValue;
use System\Entity\InternalProtocol\Request\Telegram\CallbackData;
use System\Entity\InternalProtocol\TGKeyboardAction;
use System\Entity\Repository\Button;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

/**
 * Class TelegramKeyboard
 * @package System\Component\PayBot
 */
class TGKeyboard
{
    const BUTTON_NAME_LENGTH = 19;

    /**
     * @param string $menu
     * @param string $search
     * @param string $updatePhone
     * @param string $privateOffice
     *
     * @return ReplyKeyboardMarkup
     *
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public static function navigationButtons(string $menu, string $search, string $updatePhone, string $privateOffice): ReplyKeyboardMarkup
    {
        return new ReplyKeyboardMarkup(
            [
                [$menu, $privateOffice],
                [$search, new KeyboardButton(['text'=>$updatePhone, 'request_contact'=>true])]
            ],
            false,
            true
        );
    }

    /**
     * @param string $text
     * @param string $url
     * @return InlineKeyboardMarkup
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public static function link(string $text, string $url): InlineKeyboardMarkup
    {
        $keyboardButtons[] = [
            new InlineKeyboardButton([
                'text'=>$text,
                'url'=>$url
            ])
        ];

        return new InlineKeyboardMarkup($keyboardButtons);
    }

    /**
     * @param string $text
     * @param GetPaymentPageResponse $getPaymentPageResponse
     *
     * @return InlineKeyboardMarkup
     *
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public static function payButtons(string $text, GetPaymentPageResponse $getPaymentPageResponse): InlineKeyboardMarkup
    {
        $keyboardButtons[] = [
            new InlineKeyboardButton([
                'text'=>$text,
                'url'=>$getPaymentPageResponse->getUrl()
            ])
        ];

        foreach ($getPaymentPageResponse->getUserCards() as $userCard) {
            $keyboardButtons[] = [
                new InlineKeyboardButton([
                    'text'=>"{$text} " . substr($userCard->getCard(), -8),
                    'url'=>$userCard->getUrl()
                ])
            ];
        }

        return new InlineKeyboardMarkup($keyboardButtons);
    }

    /**
     * @param KeyboardValue[] $keyboardValues
     * @param CallbackData $callbackData
     *
     * @return InlineKeyboardMarkup
     *
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public static function keyboardWithCallbackData(array $keyboardValues, CallbackData $callbackData = null): InlineKeyboardMarkup
    {
        $keyboardButtons = [];
        $keyboardRow = [];

        if (!empty($keyboardValues[0]->getPaginationAction())) {
            list($paginationKeyRow, $chunkKeyboardValues) = TGKeyboard::generatePagination($keyboardValues, $callbackData);
        } else {
            $chunkKeyboardValues = $keyboardValues;
            $paginationKeyRow = [];
        }

        foreach ($chunkKeyboardValues as $keyboardValue) {
            /**@var KeyboardValue $keyboardValue*/
            $button = new InlineKeyboardButton([
                'text' => $keyboardValue->getButtonText(),
                'callback_data' => json_encode(
                    [
                        "KbAction" => $keyboardValue->getKeyboardAction(),
                        "BtnId" => $keyboardValue->getButtonId()
                    ]
                )
            ]);

            if (mb_strlen($keyboardValue->getButtonText()) > TGKeyboard::BUTTON_NAME_LENGTH) {
                $keyboardButtons[] = [$button];
            } else {
                $keyboardRow[] = $button;
                if (count($keyboardRow) === 2) {
                    $keyboardButtons[] = $keyboardRow;
                    $keyboardRow = [];
                }
            }
        }

        if (!empty($keyboardRow)) {
            $keyboardButtons[] = $keyboardRow;
        }

        $keyboardButtons[] = $paginationKeyRow;

        return new InlineKeyboardMarkup($keyboardButtons);
    }

    /**
     * @param array $keyboardValues
     * @param CallbackData|null $callbackData
     *
     * @return KeyboardValue[]
     *
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    private static function generatePagination(array $keyboardValues, CallbackData $callbackData = null): array
    {
        /**@var KeyboardValue $keyboardValue*/
        $keyboardValue = $keyboardValues[0];
        $keyboardValues = array_chunk($keyboardValues, TGKeyboardAction::CHUNK_OF_PAGINATION);
        $paginationKeyRow = [];

        if (!is_null($callbackData)) {
            $paginationIndex = $callbackData->getPaginationButtonId();
            $chunkKeyboardValues = $keyboardValues[$paginationIndex];

            if (isset($keyboardValues[$paginationIndex - 1])) {

                $paginationKeyRow[] =  new InlineKeyboardButton([
                    'text' => $keyboardValue->getPaginationBackText(),
                    'callback_data' => json_encode(
                        [
                            "KbAction" => $keyboardValue->getPaginationAction(),
                            "BtnId" => $callbackData->getButtonId(),
                            "Pg"=>true,
                            "pgBtnId"=>$paginationIndex - 1
                        ]
                    )
                ]);
            }

            if (isset($keyboardValues[$paginationIndex + 1])) {
                $paginationKeyRow[] =  new InlineKeyboardButton([
                    'text' => $keyboardValue->getPaginationForwardText(),
                    'callback_data' => json_encode(
                        [
                            "KbAction" => $keyboardValue->getPaginationAction(),
                            "BtnId" => $callbackData->getButtonId(),
                            "Pg"=>true,
                            "pgBtnId"=>$paginationIndex + 1
                        ]
                    )
                ]);
            }

        } else {
            $chunkKeyboardValues = $keyboardValues[0];

            if (isset($keyboardValues[1])) {
                $paginationKeyRow[] = new InlineKeyboardButton([
                    'text' => $keyboardValue->getPaginationForwardText(),
                    'callback_data' => json_encode(
                        [
                            "KbAction" => $keyboardValue->getPaginationAction(),
                            "BtnId" => 0,
                            "Pg" => true,
                            "pgBtnId" => 1
                        ]
                    )
                ]);
            }
        }

        return  [$paginationKeyRow, $chunkKeyboardValues];
    }

    /**
     * @param string $getPhone
     *
     * @return ReplyKeyboardMarkup
     *
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public static function contactButtons(string $getPhone): ReplyKeyboardMarkup
    {
        return new ReplyKeyboardMarkup(
            [
                [new KeyboardButton(['text'=>$getPhone, 'request_contact'=>true])]
            ],
            false,
            true
        );
    }

    /**
     * @param UserCard[] $userCards
     * @param Button $button
     *
     * @return InlineKeyboardMarkup
     *
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public static function cardListButtons(array $userCards, Button $button): InlineKeyboardMarkup
    {
        $keyboard = [];
        foreach ($userCards as $userCard) {
            $keyboard[] = [
                new InlineKeyboardButton([
                    'text' => $userCard->getCard(),
                    'callback_data' => json_encode(
                        [
                            "KbAction" => '',
                            "BtnId" => 0
                        ]
                    )
                ]),
                new InlineKeyboardButton([
                    'text' => $button->getName(),
                    'callback_data' => json_encode(
                        [
                            "KbAction" => $button->getCallBackAction(),
                            "token" => $userCard->getToken(),
                            "BtnId" => 0,
                        ]
                    )
                ]),
            ];
        }

        return new InlineKeyboardMarkup($keyboard);
    }

    /**
     * @param Button $button
     * @param string $phoneNumber
     * @return InlineKeyboardMarkup
     */
    public static function generateInlineCallbackButton(
        Button $button,
        string $phoneNumber = ''
    ): InlineKeyboardMarkup
    {
        $text = str_replace('{current_phone_number}', $phoneNumber, $button->getName());
        $callbackData = [
            "KbAction" => $button->getCallBackAction(),
            "BtnId" => $button->getId()
        ];

        return new InlineKeyboardMarkup(
            [
                [
                    [
                        'text' => $text,
                        'callback_data' => json_encode($callbackData)
                    ]
                ]
            ]
        );
    }
}