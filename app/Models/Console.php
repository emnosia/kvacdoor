<?php
class Console {

	// Push Content to server console
	static function PushConsole($server_ip, $content, $avatar = null, $steamid = null, $username = null)
	{
		$GLOBALS["DB"]->Insert("servers_messages", ["server_ip" => $server_ip, "content" => $content, "steam_id" => $steamid, "avatar" => $avatar, "username" => $username]);
	}

	// Delete Server Console Entry
	static function DeleteServerConsole($server_ip, $limit)
	{
		$GLOBALS["DB"]->Delete("servers_messages", ['server_ip' => $server_ip], "LIMIT $limit");
	}

	// Get Last Server Console Entry
	static function GetLastServerConsole($server_ip)
	{
		return $GLOBALS["DB"]->GetContent("servers_messages", ['server_ip' => $server_ip]);
	}

	// Count Server Console Entry
	static function CountServerConsole($server_ip)
	{
		return $GLOBALS["DB"]->Count("servers_messages", ['server_ip' => $server_ip]);
	}

}


?>