Feature: MainMenu
  User presses the "Menu" button and
  the telegram server sends a request.

  Scenario: Sending request when the user is pressed "Menu" button

    When Telegram server send a "POST" request that contain:
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
          "first_name": "Ivan",
          "last_name": "Malyi",
          "type": "private"
        },
        "date": 1549361956,
        "text": "Меню"
      }
    }
    """

    And Database table "chats" consist:
      |id | user_id | current_stage | current_sub_stage | current_cheque_id | current_localization | provider_chat_id   | chat_bot_id | phone        |
      | 1 | 1       | 21            | 1                 | 0                 | "RU"                 | {ReceiverTGChatId} | 1           | 380670000001 |

    And Database table "users" consist:
      | id | first_name | last_name | phone_number |
      | 1  | "Ivan"     | "Malyi"   |              |

    And Database table "chats_history" consist:
      | id | chat_id | user_id | stage | sub_stage | localization |
      | 7  | 1       | 1       | 21    | 0         | "RU"         |