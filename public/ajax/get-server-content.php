<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}
header('Content-Type: application/json');
require_once('../../app/Models/includes.php');
if (!User::isAuthentified() || !CSRF::isAjaxRequest() || !Server::ServerExist($_GET['id']))
{
    die("Bad request");
}

$server = Server::GetServer($_GET['id']);

if($server['owner'] == $AUTHUSER['id'] || $AUTHUSER['roles'] == 3)
{
	echo json_encode($server);
}

?>