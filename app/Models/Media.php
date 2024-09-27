<?php
class Media {

	static function base64ToImage($output_file, $data) {
	    $file = fopen($output_file, "wb");

	    fwrite($file, base64_decode($data));
	    fclose($file);

	    return $output_file;
	}

	static function SelectLastMedia($ip, $type, $nbr = 5)
	{
		$data = $GLOBALS['DB']->GetContent('servers_medias', ['server_ip' => $ip, 'type' => $type], "ORDER BY created_at DESC LIMIT $nbr");
		return array_reverse($data);
	}

	static function AddMedia($filename, $name, $steamid, $pip, $sip, $type)
	{
		$GLOBALS['DB']->Insert('servers_medias', ['filename' => $filename, 'player_name' => $name, 'player_steam' => $steamid, 'player_ip' => $pip,  'server_ip' => $sip, 'type' => $type]);
	}

}


?>