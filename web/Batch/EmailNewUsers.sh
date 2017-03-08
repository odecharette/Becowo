#!/bin/bash

today=$(date +"%Y-%m-%d-%H")
/usr/local/php5.6/bin/php /homez.2332/coworkinwq/./demo/Becowo/bin/console app:send-email-new-users --env=demo > /homez.2332/coworkinwq/./demo/Becowo/var/logs/Cron/emailNewUsers-$today.txt
