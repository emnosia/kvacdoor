<?php
foreach($_GET as $key => $value)
{
	if($key !== "key") {
		die(http_response_code(429));
		break;
	}
}

require_once '_/drm.php';
?>