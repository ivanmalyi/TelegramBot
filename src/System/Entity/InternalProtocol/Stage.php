<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol;

use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;

/**
 * Class Stage
 * @package System\Entity\InternalProtocol
 */
class Stage
{
    const DEFAULT = -1;
    const NEW_USER = 1;
    const SAVE_PHONE = 2;
    const START = 3;
    const GET_SECTIONS = 4;
    const GET_OPERATORS = 5;
    const GET_SERVICES = 6;
    const GET_ITEMS = 7;
    const GET_ITEM_INPUT_FIELDS = 8;
    const VERIFY = 9;
    const GET_COMMISSIONS = 10;
    const GET_AMOUNT = 11;
    const CALCULATE_COMMISSION = 12;
    const GET_PAYMENT_PAGE = 13;
    const PAY = 14;
    const CHECK = 15;
    const CHEQUE = 16;
    const SEARCH = 17;
    const TALK = 18;
    const PRIVATE_OFFICE = 19;
    const CARD_MANAGEMENT = 20;
    const MAIN_MENU = 21;
    const WISH = 22;

    /**
     * @param TelegramRequest $request
     * @param int $stage
     *
     * @return bool
     */
    public static function isGetItemInputFields(TelegramRequest $request, int $stage): bool
    {
        return Stage::GET_ITEM_INPUT_FIELDS === $stage or
            (
                $request->getCallbackData() !== null and
                0 === $stage and
                $request->getCallbackData()->getTypeKeyboardAction() === TGKeyboardAction::GET_ITEM_INPUT_FIELDS
            );
    }

    /**
     * @param TelegramRequest $request
     * @param int $stage
     *
     * @return bool
     */
    public static function isGetItems(TelegramRequest $request, int $stage): bool
    {
        return Stage::GET_ITEMS === $stage or
            (
                $request->getCallbackData() !== null and
                0 === $stage and
                $request->getCallbackData()->getTypeKeyboardAction() === TGKeyboardAction::GET_ITEMS
            )
            or
            (
                $request->getCallbackData() !== null and
                $request->getCallbackData()->isPagination() and
                $request->getCallbackData()->getTypeKeyboardAction() === TGKeyboardAction::GET_ITEMS
            );
    }

    /**
     * @param TelegramRequest $request
     * @param int $stage
     *
     * @return bool
     */
    public static function isGetServices(TelegramRequest $request, int $stage): bool
    {
        return Stage::GET_SERVICES === $stage or
            (
                $request->getCallbackData() !== null and
                0 === $stage and
                $request->getCallbackData()->getTypeKeyboardAction() === TGKeyboardAction::GET_SERVICES
            )
            or
            (
                $request->getCallbackData() !== null and
                $request->getCallbackData()->isPagination() and
                $request->getCallbackData()->getTypeKeyboardAction() === TGKeyboardAction::GET_SERVICES
            )
            ;
    }

    /**
     * @param TelegramRequest $request
     * @param int $stage
     *
     * @return bool
     */
    public static function isGetOperators(TelegramRequest $request, int $stage): bool
    {
        return Stage::GET_OPERATORS === $stage or
            (
                $request->getCallbackData() !== null and
                0 === $stage and
                $request->getCallbackData()->getTypeKeyboardAction() === TGKeyboardAction::GET_OPERATORS
            )
            or
            (
                $request->getCallbackData() !== null and
                $request->getCallbackData()->isPagination() and
                $request->getCallbackData()->getTypeKeyboardAction() === TGKeyboardAction::GET_OPERATORS
            );
    }

    /**
     * @param TelegramRequest $request
     * @param int $stage
     *
     * @return bool
     */
    public static function isGetSections(TelegramRequest $request, int $stage): bool
    {
        return (Stage::GET_SECTIONS === $stage and $request->getCallbackData() === null) or
            (
                $request->getCallbackData() !== null and
                $request->getCallbackData()->getTypeKeyboardAction() === TGKeyboardAction::GET_SECTIONS
            );
    }

    /**
     * @param TelegramRequest $request
     * @param int $stage
     *
     * @return bool
     */
    public static function isStart(TelegramRequest $request, int $stage): bool
    {
        $startParams = explode(' ', trim($request->getMessage()->getText()));

        return $startParams[0] === '/start' and Stage::SAVE_PHONE !==$stage or Stage::START === $stage;
    }

    /**
     * @param int $stage
     *
     * @return bool
     */
    public static function isSearch(int $stage): bool
    {
        return Stage::SEARCH === $stage;
    }

    /**
     * @param TelegramRequest $request
     * @param int $stage
     *
     * @return bool
     */
    public static function isSavePhone(TelegramRequest $request, int $stage): bool
    {
        return !is_null($request->getMessage()->getContact()) or Stage::SAVE_PHONE === $stage;
    }

    /**
     * @param TelegramRequest $request
     * @param int $stage
     *
     * @return bool
     */
    public static function isCardManagement(TelegramRequest $request, int $stage): bool
    {
        return Stage::CARD_MANAGEMENT === $stage or
            (
                $request->getCallbackData() !== null and
                0 === $stage and
                (
                    $request->getCallbackData()->getTypeKeyboardAction() === TGKeyboardAction::GET_CARD_LIST or
                    $request->getCallbackData()->getTypeKeyboardAction() === TGKeyboardAction::DELETE_CARD
                )
            );
    }

    /**
     * @param TelegramRequest $request
     * @param int $stage
     *
     * @return bool
     */
    public static function isMainMenu(TelegramRequest $request, int $stage): bool
    {
        return Stage::MAIN_MENU === $stage or (
            $request->getCallbackData() !== null and
            $request->getCallbackData()->getTypeKeyboardAction() === TGKeyboardAction::GET_MENU_SERVICE
            );
    }
}