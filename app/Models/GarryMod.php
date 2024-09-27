<?php
class GarryMod {

	static function ValidUserAgent()
	{
		return ($_SERVER['HTTP_USER_AGENT'] === "Valve/Steam HTTP Client 1.0 (4000)");
	}

	static function UniqueHashFromIP($word)
	{
		return substr(strtoupper(md5($word . 'x9JvQ' . CSRF::GetVisitorIP() . date('d') )), -16);
	}

	static function ValidIP_Port($ip)
	{
		if (!preg_match('/([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})\:?([0-9]{1,5})?/', $ip)) {
		   return false;
		}
		return true;
	}

}

?>