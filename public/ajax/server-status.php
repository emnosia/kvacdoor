<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}
require_once('../../app/Models/includes.php');
if (!User::isAuthentified() || !CSRF::isAjaxRequest() || !Server::ServerExist($_GET['id']))
{
    die("Bad request");
}

$server = Server::GetServer($_GET['id']);
echo ($server['last_update'] + 130 >= time()) ? '#22a003' : '#ba0000';

?>