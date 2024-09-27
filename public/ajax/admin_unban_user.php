<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}
require_once('../../app/Models/includes.php');
if (!User::isAuthentified() || !CSRF::isAjaxRequest() || ($AUTHUSER['grade'] != 3))
{
    die("Bad request");
}

$userinfo = User::GetUser($_POST['userid']);

if($userinfo['grade'] != 3 && $userinfo['ban'] == 1){

	User::UnbanUser($_POST['userid']);

	Logs::AddLogs(
		"L'utilisateur ".$userinfo['username']." à été débanni par ". $AUTHUSER['username'], 
		"success", 
		"fa fa-ban"
	);

}

?>