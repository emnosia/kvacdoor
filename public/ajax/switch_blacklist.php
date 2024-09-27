<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once('../../app/Models/includes.php');



if(isset($_GET["steamid"]) AND !empty($_GET["steamid"])){
	if($_GET["action"] == 'blacklist'){
		Player::UpdateBlacklist($_GET['steamid'], 1);
	} else {
		Player::UpdateBlacklist($_GET['steamid'], 0);
	}
}

?>