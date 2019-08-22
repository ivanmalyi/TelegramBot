Feature: SavePhone
  To start working with the chat bot | the user presses the start button and
  the telegram server sends a request.

  Scenario: Sending a command /start  when the user is not registered

    Then Telegram server send a "POST" request that contain:
    """
    {
      "update_id": 238142097,
      "message": {
        "message_id": 3848,
        "from": {
          "id": {ReceiverTGChatId},
          "is_bot": false,
          "first_name": "Ivan",
          "last_name": "Malyi",
          "username": "ivan_malyi93",
          "language_code": "ru"
        },
        "chat": {
          "id": {ReceiverTGChatId},
          "first_name": "{ReceiverTGFirstName}",
          "last_name": "{ReceiverTGLastName}",
          "username": "ivan_malyi93",
          "type": "private"
        },
        "date": 1558447081,
        "reply_to_message": {
          "message_id": 3841,
          "from": {
            "id": 680124193,
            "is_bot": true,
            "first_name": "TestFcSystemPaybot",
            "username": "TestFcSystemPaybot"
          },
          "chat": {
            "id": {ReceiverTGChatId},
            "first_name": "{ReceiverTGFirstName}",
            "last_name": "{ReceiverTGLastName}",
            "username": "ivan_malyi93",
            "type": "private"
          },
          "date": 1558445940,
          "text": "{ReceiverTGFirstName} приветствую, нажми на кнопку # Новый платеж #"
        },
        "contact": {
          "phone_number": "+380670000001",
          "first_name": "{ReceiverTGFirstName}",
          "last_name": "{ReceiverTGLastName}",
          "user_id": {ReceiverTGChatId}
        }
      }
}
    """

    And Database table "chats" consist:
    |id | user_id | current_stage | current_sub_stage | current_cheque_id | current_localization | provider_chat_id     | chat_bot_id | phone        |
    | 1 | 1       | 2             | 1                 | 0                 | "RU"                 | "{ReceiverTGChatId}" | 1           | 380670000001 |

    And Database table "users" consist:
    | id | first_name              | last_name              | phone_number |
    | 1  | "{ReceiverTGFirstName}" | "{ReceiverTGLastName}" |              |

    And Database table "chats_history" consist:
    | id | chat_id | user_id | stage | sub_stage | localization |
    | 3  | 1       | 1       | 2     | 0         | "RU"         |
