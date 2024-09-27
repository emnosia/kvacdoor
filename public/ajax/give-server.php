<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}

header('Content-Type: application/json');
require_once('../../app/Models/includes.php');
if (!User::isAuthentified() || !CSRF::isAjaxRequest() || !Server::ServerExist($_GET['server']))
{
    die("Bad request");
}

$server = Server::GetServer($_GET['server']);

if($AUTHUSER['id'] == $server['owner'] OR $AUTHUSER['roles'] == 3) {
	Server::GiveServer($_GET['target'], $_GET['server']);
	die(json_encode('success'));
} else {
	die(json_encode("Vous n'avez pas la permissions de faire ceci!"));
}

?>