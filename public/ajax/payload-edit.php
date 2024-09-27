<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}
require_once '../../app/Models/includes.php';
if (!User::isAuthentified() || !CSRF::isAjaxRequest() || !isset($_POST['id']))
{
    die("Bad request");
}

$payload = Payload::get($_POST['id']);

if((int)$payload['owner'] === (int)$_SESSION['user']['id'])
{

	$clientside = 0;
	if($_POST['clientside'] == "true")
	{
		$clientside = 1;
	}

	// VERIFIE L'ARGUMENT
	if(preg_match("#{{argument}}#", $_POST['content'])){
		$args = 1;
	} else {
		$args = 0;
	}

	Payload::EditPayload($_POST['id'],$_POST['name'], $_POST['content'], $clientside, 10, $args);
	die('success');
}
else
{
	die('error');
}

?>