#!/bin/bash

today=$(date +"%Y-%m-%d-%H")
/usr/local/php7.0/bin/php /homez.2332/coworkinwq/./demo/Becowo/bin/console app:get-email-events --env=demo > /homez.2332/coworkinwq/./demo/Becowo/var/logs/Cron/getEmailEvents-$today.txt
