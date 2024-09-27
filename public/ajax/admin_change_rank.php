<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}
require_once('../../app/Models/includes.php');
if (!User::isAuthentified() || !CSRF::isAjaxRequest() || ($AUTHUSER['roles'] != 3))
{
    die("Bad request");
}

User::setRole($_POST['userid'], $_POST['rank']);


$username = User::GetUser($_POST['userid'])['username'];
$rank = "Premium";
if($_POST['rank'] == 0){
	$rank = "Free";
}

Logs::AddLogs(
	"L'utilisateur ".htmlentities($AUTHUSER['username'])." à mis le grade ($rank) à $username", 
	"orange", 
	"fa fa-refresh"
);

?>