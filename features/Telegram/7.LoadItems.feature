Feature: GetItems
  User presses button with service and
  the telegram server sends a request.

  Scenario: Sending request when the user is pressed button with item.
  Service has one item

    When Telegram server send a "POST" request that contain:
    """
    {
      "update_id": 32126746,
      "callback_query": {
        "id": "2096331739722715975",
        "from": {
          "id": {ReceiverTGChatId},
          "is_bot": false,
          "first_name": "Ivan",
          "last_name": "Malyi",
          "language_code": "ru"
        },
        "message": {
          "message_id": 1438,
          "from": {
            "id": {ReceiverTGChatId},
            "is_bot": true,
            "first_name": "SystemPaybot",
            "username": "DneprPaybot"
          },
          "chat": {
            "id": {ReceiverTGChatId},
          "first_name": "Ivan",
          "last_name": "Malyi",
            "type": "private"
          },
          "date": 1552294926,
          "text": " "
        },
        "chat_instance": "-7252885498874711130",
        "data": "{\"KbAction\":\"get_items\", \"BtnId\":47}"
      }
    }
    """

    And Database table "chats" consist:
      |id | user_id | current_stage | current_sub_stage | current_cheque_id | current_localization | provider_chat_id           | chat_bot_id | phone        |
      | 1 | 1       | 7             | 1                 | 0                 | "RU"                 | "{ReceiverTGChatId}" | 1           | 380670000001 |

    And Database table "chats_history" consist:
      | id | chat_id | user_id | stage | sub_stage | localization |
      | 13 | 1       | 1       | 7     | 0         | "RU"         |

  Scenario: Sending request when the user is pressed button with item.
  Service has many items

    When Telegram server send a "POST" request that contain:
    """
    {
      "update_id": 32126746,
      "callback_query": {
        "id": "2096331739722715975",
        "from": {
          "id": {ReceiverTGChatId},
          "is_bot": false,
          "first_name": "Ivan",
          "last_name": "Malyi",
          "language_code": "ru"
        },
        "message": {
          "message_id": 1438,
          "from": {
            "id": {ReceiverTGChatId},
            "is_bot": true,
            "first_name": "SystemPaybot",
            "username": "DneprPaybot"
          },
          "chat": {
            "id": {ReceiverTGChatId},
          "first_name": "Ivan",
          "last_name": "Malyi",
            "type": "private"
          },
          "date": 1552294926,
          "text": " "
        },
        "chat_instance": "-7252885498874711130",
        "data": "{\"KbAction\":\"get_items\", \"BtnId\":42}"
      }
    }
    """

    And Database table "chats" consist:
      |id | user_id | current_stage | current_sub_stage | current_cheque_id | current_localization | provider_chat_id           | chat_bot_id | phone        |
      | 1 | 1       | 8             | 1                 | 0                 | "RU"                 | "{ReceiverTGChatId}" | 1           | 380670000001 |

    And Database table "chats_history" consist:
      | id | chat_id | user_id | stage | sub_stage | localization |
      | 15 | 1       | 1       | 8     | 0         | "RU"         |

    And Database table "cheques" consist:
      | id | chat_id | user_id | account | item_id | amount | commission | status | billing_cheque_id |
      | 1  | 1       | 1       |         | 1       | 0      | 0          | 0      | 0                 |
