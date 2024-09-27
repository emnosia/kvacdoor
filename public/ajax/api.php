<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die("Bad request");
}

require_once('../../app/Models/includes.php');
if (!User::isAuthentified() || !CSRF::isAjaxRequest())
{
    die("Bad request");
}

Logs::AddLogs(
	"L'utilisateur ".htmlentities($AUTHUSER['username']) ." à tenter de faire un CTRL + S", 
	"danger", 
	"fa fa-exclamation-triangle"
);

?>