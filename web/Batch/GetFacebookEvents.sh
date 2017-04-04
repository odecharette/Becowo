#!/bin/bash

today=$(date +"%Y-%m-%d-%H")
/usr/local/php7.0/bin/php /homez.2332/coworkinwq/./www/Becowo/bin/console app:get-facebook-events --env=prod > /homez.2332/coworkinwq/./www/Becowo/var/logs/Cron/getFacebookEvents-$today.txt
/usr/local/php7.0/bin/php /homez.2332/coworkinwq/./www/Becowo/bin/console algolia:reindex BecowoCoreBundle:Event --env=prod > /homez.2332/coworkinwq/./www/Becowo/var/logs/Cron/getFacebookEvents-$today.txt

