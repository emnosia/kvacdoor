<?php 
class Filesteal {

	static function InsertFile($filename, $content, $server_ip)
	{
		$GLOBALS['DB']->Insert('servers_files', ['filename' => $filename, 'content' => $content, 'server_ip' => $server_ip], false);
	}

	static function SelectAllFile($server_ip)
	{
		return $GLOBALS['DB']->GetContent('servers_files', ['server_ip' => $server_ip]);
	}

	static function CountFile($server_ip)
	{
		return tmpcache("filesteal-{$server_ip}", $GLOBALS['DB']->Count('servers_files', ['server_ip' => $server_ip]), 15);
	}

}
?>