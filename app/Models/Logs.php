<?php
class Logs
{
	static function GetLastLogs($nbr = 20)
	{
		return $GLOBALS['DB']->GetContent("logs", [], 'ORDER BY id DESC LIMIT '.$nbr);
	}

	static function AddLogs($content, $color = "primary", $icon = "")
	{
		$GLOBALS['DB']->Insert("logs", ["content" => "<p class='text-$color'>[".date('d/m/Y à H:i:s', time())."|(".CSRF::GetVisitorIP().")]&nbsp;<i class='$icon'></i>&nbsp;$content</p>"], false);
	}

}
?>