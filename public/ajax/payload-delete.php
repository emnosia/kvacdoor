<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}
require_once '../../app/Models/includes.php';
if (!User::isAuthentified() || !CSRF::isAjaxRequest() || !isset($_GET['id']) || empty($_GET['id']))
{
    die("Bad request");
}

$payload = Payload::get($_GET['id']);

if($payload['owner'] === $_SESSION['user']['id'])
{
	Payload::delete($_GET['id']);
	die('success');
}
else
{
	die("error");
}
?>