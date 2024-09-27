<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}
require_once('../../app/Models/includes.php');
if (!User::isAuthentified() || !CSRF::isAjaxRequest())
{
    die("Bad request");
}

if($_SESSION["RateLimit"]["time"] != date("s") or !isset($_SESSION["RateLimit"])){
    $_SESSION["RateLimit"] = array("time" => date("s"), "rate" => 0);
}

$_SESSION["RateLimit"]['rate'] = $_SESSION["RateLimit"]['rate'] + 1;

if($_SESSION["RateLimit"]['rate'] >= 2){
	session_unset();
	session_destroy();
    die(http_response_code(403));
}
 

echo 'ooffed';

?>