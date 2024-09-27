<?php

if(isset($_POST['edit-profile'])) {

	if(empty($_POST['description']) || !isset($_POST['description']) || strlen($_POST['description']) > 80) {
		$description = $AUTHUSER['description'];
	} else {
		$description = $_POST['description'];
	}

	if(empty($_POST['steamid']) || !isset($_POST['steamid'])) {
		$steamid = $AUTHUSER['steamid'];
	} else {
		$steamid = $_POST['steamid'];
	}

	Profile::EditProfile($_SESSION['user']['id'], $description, $steamid);
	die(header('location:'.CURRENT_PAGE));

}

if(!User::isExist($_GET['id'])){
    die(http_response_code(444));
}

$userprofile = User::GetUser($_GET['id']);

if($userprofile['ip'] != "0.0.0.0" && $AUTHUSER['roles'] == 3)
{
	$info_ip = json_decode(file_get_contents("http://ip-api.com/json/{$userprofile['ip']}"));
}

$title = htmlentities($userprofile['username']);

$lastlogin = CSRF::TimeAgo($userprofile['last_login']);

$badges = User::getUserBadge($_GET['id']);

if ($userprofile['roles'] >= 2) {
	array_push($badges, [
		'id' => 3,
		'name' => "Technical Assistance",
		'icon' => "https://cdn.discordapp.com/emojis/768136820440825866.png?v=1",
	]);
}

if ($userprofile['discord_nitro'] != 0) {
	array_push($badges, [
		'id' => 10,
		'name' => "Nitro Subscriber",
		'icon' => "/assets/img/boost.png",
	]);
}

if ($userprofile['roles'] >= 1) {
	array_push($badges, [
		'id' => 3,
		'name' => "Premium Members",
		'icon' => "/assets/img/badges/star.png",
	]);
}

if($lastlogin === "Now")
{
	$lastlogin = '<span class="text-success">Currently Online</span>';
} else {
	$lastlogin = '<span class="text-orange">'.$lastlogin.'</span>';
}

if($userprofile['last_login'] == 0)
{
    $lastlogin = '<span class="text-danger">Never connected</span>';
    $user['online'] = false;
}

$user_agent = $userprofile['user_agent'];

function getOS()
{

	global $user_agent;

	$os_platform    =   "Unknown OS Platform";

	$os_array       =   array(
		'/windows nt 10/i'     =>  'Windows 10',
		'/windows nt 6.3/i'     =>  'Windows 8.1',
		'/windows nt 6.2/i'     =>  'Windows 8',
		'/windows nt 6.1/i'     =>  'Windows 7',
		'/windows nt 6.0/i'     =>  'Windows Vista',
		'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
		'/windows nt 5.1/i'     =>  'Windows XP',
		'/windows xp/i'         =>  'Windows XP',
		'/windows nt 5.0/i'     =>  'Windows 2000',
		'/windows me/i'         =>  'Windows ME',
		'/win98/i'              =>  'Windows 98',
		'/win95/i'              =>  'Windows 95',
		'/win16/i'              =>  'Windows 3.11',
		'/macintosh|mac os x/i' =>  'Mac OS X',
		'/mac_powerpc/i'        =>  'Mac OS 9',
		'/linux/i'              =>  'Linux',
		'/kalilinux/i'          =>  'KaliLinux',
		'/ubuntu/i'             =>  'Ubuntu',
		'/iphone/i'             =>  'iPhone',
		'/ipod/i'               =>  'iPod',
		'/ipad/i'               =>  'iPad',
		'/android/i'            =>  'Android',
		'/blackberry/i'         =>  'BlackBerry',
		'/webos/i'              =>  'Mobile',
		'/Windows Phone/i'      =>  'Windows Phone'
	);

	foreach ($os_array as $regex => $value) {

		if (preg_match($regex, $user_agent)) {
			$os_platform    =   $value;
		}
	}

	return $os_platform;
}
function getBrowser()
{

	global $user_agent;

	$browser        =   "Unknown Browser";

	$browser_array  =   array(
		'/msie/i'       =>  'Internet Explorer',
		'/firefox/i'    =>  'Firefox',
		'/Mozilla/i'	=>	'Mozilla',
		'/Mozilla/5.0/i' =>	'Mozilla',
		'/safari/i'     =>  'Safari',
		'/chrome/i'     =>  'Chrome',
		'/edge/i'       =>  'Edge',
		'/opera/i'      =>  'Opera',
		'/OPR/i'        =>  'Opera',
		'/netscape/i'   =>  'Netscape',
		'/maxthon/i'    =>  'Maxthon',
		'/konqueror/i'  =>  'Konqueror',
		'/Bot/i'		=>	'BOT Browser',
		'/Valve Steam GameOverlay/i'  =>  'Steam',
		'/mobile/i'     =>  'Handheld Browser'
	);

	foreach ($browser_array as $regex => $value) {

		if (preg_match($regex, $user_agent)) {
			$browser    =   $value;
		}
	}

	return $browser;
}

?>