<?php

declare(strict_types=1);

namespace System\Entity\InternalProtocol;


class TGKeyboardAction
{
    const GET_SECTIONS = 'get_sections';
    const GET_OPERATORS = 'get_operators';
    const GET_SERVICES = 'get_services';
    const GET_ITEMS = 'get_items';
    const GET_ITEM_INPUT_FIELDS = 'get_item_input_fields';
    const CHUNK_OF_PAGINATION = 10;
    const GET_CARD_LIST = 'get_card_list';
    const DELETE_CARD = 'del_card';
    const GET_MENU_SERVICE = 'get_menu_service';
}