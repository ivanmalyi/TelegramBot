#!/bin/sh

sudo php /var/www/html/sistema.chatBot/vendor/robmorgan/phinx/bin/phinx rollback -t 0

php /var/www/html/sistema.chatBot/vendor/robmorgan/phinx/bin/phinx migrate

php /var/www/html/sistema.chatBot/vendor/robmorgan/phinx/bin/phinx seed:run

sudo vendor/bin/behat