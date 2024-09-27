<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}
require_once '../../app/Models/includes.php';
if (!CSRF::isAjaxRequest() || !isset($_GET['server']) || !isset($_GET['id']))
{
    //die("Bad request");
}

$payload = Payload::get($_GET['id']);
$serverinfo = Server::GetServer($_GET['server']);

if($payload['clientside'] == 1) {
	include '../../data/clientside.php';
	$payload['content'] = $clientside_start.$payload['content'].$clientside_end;
}

$argument = (preg_match("#{{argument}}#", $payload['content']));

if($argument && !isset($_GET['args'])) {
	die('args required');
} elseif($argument) {
	$payload['content'] = str_replace("{{argument}}", $_GET['args'], $payload['content']);
}

Payload::SendPayloadToServerID($_GET['server'], $payload['content']);

Logs::AddLogs(
	"User ".htmlentities($AUTHUSER['username'])." executed payload (".htmlentities($payload['name']).") on server ".htmlentities($serverinfo['hostname']), 
	"info", 
	"fas fa-paper-plane"
);

?>