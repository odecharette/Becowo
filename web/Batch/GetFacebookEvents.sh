#!/bin/bash

today=$(date +"%Y-%m-%d-%H")
/usr/local/php5.6/bin/php /homez.2332/coworkinwq/./demo/Becowo/bin/console app:get-facebook-events --env=demo > /homez.2332/coworkinwq/./demo/Becowo/var/logs/Cron/getFacebookEvents-$today.txt
