<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}

require('../../config/database.php');
require('../../includes/functions.php');

if(isBlacklist()){
	include("../404.php");
	die();
}

if(!isConnected()){
	include("../404.php");
	die();
}

function steamid64_to_steamid2($steamid64) {
    $accountID = bcsub($steamid64, '76561197960265728');
    return 'STEAM_0:'.bcmod($accountID, '2').':'.bcdiv($accountID, 2);
}

$q = $db->prepare("SELECT id, steamname, steamid64, country FROM players");
$q->execute();
$player = $q->fetchAll();

$list = [];

foreach ($player as $players) {

	$flag = '<div align="center"><img src="https://www.countryflags.io/'.$players["country"].'/shiny/64.png" style="max-width:20px;"></div>';
	$button = '<a onclick="view_player('.$players["id"].');">Details</a>';

	array_push($list, ["DT_RowId" => $players["id"], $flag, $players["steamname"], '<a>'.steamid64_to_steamid2($players["steamid64"]).'</a>', $button]);
}

echo json_encode(['data' => $list]);
?>