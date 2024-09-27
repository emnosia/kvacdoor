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

$userinfo = User::GetUser($_POST['userid']);

if($userinfo['rank'] != 3 && $userinfo['ban'] == 0){

	User::BanUser($_POST['userid'], $_POST['reason']);

	Logs::AddLogs(
		"L'utilisateur ".$userinfo['username']." à été banni par ".$AUTHUSER['username'] ." Raison : ".htmlentities($_POST['reason']), 
		"danger", 
		"fa fa-ban"
	);

}

?>