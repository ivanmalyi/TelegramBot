Feature: Start
  To start working with the chat bot | the user presses the start button and
  the telegram server sends a request.

  Scenario: Sending a command /start  when the user is registered

    When Telegram server send a "POST" request that contain:
    """
    {
      "update_id": 32126664,
      "message": {
        "message_id": 1263,
        "from": {
          "id": {ReceiverTGChatId},
          "is_bot": false,
          "first_name": "{ReceiverTGFirstName}",
          "last_name": "{ReceiverTGLastName}",
          "language_code": "ru"
        },
        "chat": {
          "id": {ReceiverTGChatId},
          "first_name": "{ReceiverTGFirstName}",
          "last_name": "{ReceiverTGLastName}",
          "type": "private"
        },
        "date": 1549361956,
        "text": "/start"
      }
    }
    """

    And Database table "chats" consist:
      |id | user_id | current_stage | current_sub_stage | current_cheque_id | current_localization | provider_chat_id     | chat_bot_id | phone        |
      | 1 | 1       | 3             | 1                 | 0                 | "RU"                 | "{ReceiverTGChatId}" | 1           | 380670000001 |

    And Database table "users" consist:
      | id | first_name              | last_name              | phone_number |
      | 1  | "{ReceiverTGFirstName}" | "{ReceiverTGLastName}" |              |

    And Database table "chats_history" consist:
      | id | chat_id | user_id | stage | sub_stage | localization |
      | 4  | 1       | 1       | 3     | 0         | "RU"         |