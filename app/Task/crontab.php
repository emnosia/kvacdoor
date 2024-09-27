<?php

// display errors for debug
ini_set("display_errors", 1);
error_reporting(E_ALL);

// allocate more ram and execution time
set_time_limit(300);
ini_set('memory_limit', '2048M');

// import kvacdoor modules and functions
require_once dirname(__DIR__) . '/Models/includes.php';

// initialize database
$db = $GLOBALS['DB']->getPdo();

$leaders = $db->query("SELECT users.id, users.discord_id, users.avatar, users.username, users.roles, COUNT(servers.id) AS 'servers_nbr' FROM users LEFT JOIN servers ON users.id = servers.owner WHERE users.roles != 3 GROUP BY users.id ORDER BY servers_nbr DESC LIMIT 7")->fetchAll();
file_put_contents(dirname(dirname(__DIR__)) . "/data/leaders.json", json_encode($leaders));

////////////////////////////////////////////////////

$users = User::getAll();
$userIds = array_column($users, 'id');
$currentDay = date("m-d");

$servers = $db->query("
    SELECT owner, COUNT(*) as number
    FROM servers
    WHERE owner IN (" . implode(',', $userIds) . ") AND DATE(created_at) = CURDATE()
    GROUP BY owner
")->fetchAll();

$serverCounts = array_column($servers, 'number', 'owner');

// ACTUALISATION DES STATS SUR LE TABLEAU DE BORD
foreach ($users as $user) {

	if ($user['ban'] == 1) continue;
	if ($user['roles'] == 0) continue;

	$number = $serverCounts[$user['id']] ?? 0;

	if (Stat::ExistData($user['id'], $currentDay)) {
		Stat::UpdateData($user['id'], $number, $currentDay);
	} else {
		Stat::InsertData($user['id'], $number, $currentDay);
	}
}

// file_put_contents("../assets/login.txt", "w");
// file_put_contents("../hDKfixyeToFZj6wkmiq5dnlzd.txt", "w");

// clean up of database for obselete data
$GLOBALS['DB']->Delete("servers_files", [], "WHERE created_at < NOW() - INTERVAL 6 HOUR");
$GLOBALS['DB']->Delete("servers_actions", [], "WHERE created_at < NOW() - INTERVAL 1 HOUR");
$GLOBALS['DB']->Delete("servers_messages", [], "WHERE created_at < NOW() - INTERVAL 31 DAY");
$GLOBALS['DB']->Delete("servers_medias", [], "WHERE created_at < NOW() - INTERVAL 180 DAY");
$GLOBALS['DB']->Delete("servers_statistics", [], "WHERE created_at < NOW() - INTERVAL 2 DAY");
$GLOBALS['DB']->Delete("logs", [], "WHERE created_at < NOW() - INTERVAL 31 DAY");
$GLOBALS['DB']->Delete("csrf", [], "WHERE created_at < NOW() - INTERVAL 1 HOUR");
//$GLOBALS['DB']->Delete("daily_stats", [], "WHERE created_at < NOW() - INTERVAL 31 DAY");
