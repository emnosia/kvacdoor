<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}
ini_set("display_errors", 1);
error_reporting(E_ALL);


require_once '../../app/Models/includes.php';
if (!User::isAuthentified() || !CSRF::isAjaxRequest() || !isset($_GET['ip']) || !isset($_GET['rcon']))
{
    die("Bad request");
}

if(!$_SERVER['HTTP_REFERER'] == "https://kvacdoor.cz/history"){
    session_unset();
	session_destroy();
    die(http_response_code(403));
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
 

$ip = $_GET['ip'];
$rcon = $_GET['rcon'];
$key = $AUTHUSER['infectkey'];

$opts = array('http' =>
    array(
        'method'  => 'GET',
        'header'  => 'Content-type: application/x-www-form-urlencoded'
    )
);
 
$context  = stream_context_create($opts);
$result = file_get_contents("https://panel.wadixserv.com/api/rcon.php?ip={$ip}&rcon={$rcon}&key={$key}", false, $context);

Logs::AddLogs(
	"L'utilisateur ".htmlentities($AUTHUSER['username'])." à reconnecter par rcon (".htmlentities($_GET['ip']).")", 
	"pink", 
	"fa fa-rss"
);

die($result);

?>