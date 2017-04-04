#!/bin/bash

today=$(date +"%Y-%m-%d-%H")
/usr/local/php7.0/bin/php /homez.2332/coworkinwq/./www/Becowo/bin/console app:send-email-new-users --env=prod > /homez.2332/coworkinwq/./www/Becowo/var/logs/Cron/emailNewUsers-$today.txt
