<?php

ob_start();

$url = "https://demo.becowo.com/email/newusers";

while (ob_get_status())
{
	ob_end_clean();
}

header("Location: $url");
?>