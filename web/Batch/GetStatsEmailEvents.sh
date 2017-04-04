#!/bin/bash

today=$(date +"%Y-%m-%d-%H")
/usr/local/php7.0/bin/php /homez.2332/coworkinwq/./www/Becowo/bin/console app:get-stats-email-events --env=prod > /homez.2332/coworkinwq/./www/Becowo/var/logs/Cron/getStatsEmailEvents-$today.txt
