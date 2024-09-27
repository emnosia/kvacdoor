<?php

if (isset($_POST['message']) && isset($_POST['steamid64'])) {

	require_once '../app/Models/includes.php';

	$ip = htmlentities($_POST['ip']);
	$msg =  $_POST['name'] . ' : ' . $_POST['message'];

	$limit = 60;

	$api = tmpcache("steam-{$_POST['steamid64']}", json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=6192A155B22B585694C24CC24029FA76&steamids={$_POST['steamid64']}")), 3600);

	$avatar = $api->response->players[0]->avatarmedium;

	Console::PushConsole($ip, $_POST['message'], $avatar, $_POST['steamid64'], $_POST['name']);

	$CountChat = Console::CountServerConsole($ip);

	if ($CountChat > $limit) {
		$limit = ($CountChat - $limit);
		Console::DeleteServerConsole($ip, $limit);
	}
	die();
}