Feature: Start
  To start working with the chat bot | the user presses the start button and
  the telegram server sends a request.

  Scenario: Sending a command /start  when the user is not registered

    Then Telegram server send a "POST" request that contain:
    """
    {
      "update_id": 32126664,
      "message": {
        "message_id": 1263,
        "from": {
          "id": {ReceiverTGChatId},
          "is_bot": false,
          "first_name": "Ivan",
          "last_name": "Malyi",
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
    |id | user_id | current_stage | current_sub_stage | current_cheque_id | current_localization | provider_chat_id     | chat_bot_id | phone |
    | 1 | 1       | 2             | 0                 | 0                 | "RU"                 | "{ReceiverTGChatId}" | 1           |       |

    And Database table "users" consist:
    | id | first_name              | last_name              | phone_number |
    | 1  | "{ReceiverTGFirstName}" | "{ReceiverTGLastName}" |              |

    And Database table "chats_history" consist:
    | id | chat_id | user_id | stage | sub_stage | localization |
    | 2  | 1       | 1       | 2     | 0         | "RU"         |
