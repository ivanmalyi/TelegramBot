Feature: Search
  User presses the "# Search #" button and
  the telegram server sends a request.

  Scenario: Sending request when the user is pressed "# Search #" button

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
        "text": "# Поиск #"
      }
    }
    """

    And Database table "chats" consist:
      |id | user_id | current_stage | current_sub_stage | current_cheque_id | current_localization | provider_chat_id           | chat_bot_id | phone        |
      | 1 | 1       | 17            | 1                 | 0                 | "RU"                 | "{ReceiverTGChatId}" | 1           | 380670000001 |

    And Database table "chats_history" consist:
      | id | chat_id | user_id | stage | sub_stage | localization |
      | 5  | 1       | 1       | 17    | 0         | "RU"         |

  Scenario: Sending request when the user entered name item

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
        "text": "Киевстар"
      }
    }
    """

    And Database table "chats" consist:
      |id | user_id | current_stage | current_sub_stage | current_cheque_id | current_localization | provider_chat_id           | chat_bot_id | phone        |
      | 1 | 1       | 17            | 1                 | 0                 | "RU"                 | "{ReceiverTGChatId}" | 1           | 380670000001 |

    And Database table "chats_history" consist:
      | id | chat_id | user_id | stage | sub_stage | localization |
      | 6  | 1       | 1       | 17    | 1         | "RU"         |