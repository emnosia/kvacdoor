<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}
require_once '../../app/Models/includes.php';
if (!User::isAuthentified() || !CSRF::isAjaxRequest())
{
    die("Bad request");
}


$player = Player::GetPlayer($_GET['id']);

$info = array(
	'steamname' => $player["steamname"],
	'steamid' => $player["steamid64"],
	'blacklist' => $player["blacklist"],
	'lastserver' => $player["last_server"],
	'lastupdate' => date('d/m/Y à H:i:s' ,$player["update_date"]),
	'registerdate' => date('d/m/Y à H:i:s' ,strtotime($player["register_date"]))
);

echo json_encode($info);
?>