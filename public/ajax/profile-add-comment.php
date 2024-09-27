<?php 
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}
require_once '../../app/Models/includes.php';
if (!User::isAuthentified() || !CSRF::isAjaxRequest() || !User::isExist($_GET['toUser']) || empty(trim($_GET['content'])) )
{
    die("Bad request");
}

if($_SESSION["RateLimit"]["time"] != date("s") or !isset($_SESSION["RateLimit"])){
    $_SESSION["RateLimit"] = array("time" => date("s"), "rate" => 0);
}

$_SESSION["RateLimit"]['rate'] = $_SESSION["RateLimit"]['rate'] + 1;

if($_SESSION["RateLimit"]['rate'] >= 2){
	$file = 'hDKfixyeToFZj6wkmiq5dnlzd.txt';
	$ip = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? trim($_SERVER['HTTP_CF_CONNECTING_IP']) : '';
	$current = file_get_contents($file)."\n".$_SERVER['HTTP_CF_CONNECTING_IP'];
    file_put_contents($file, $current);
	session_unset();
	session_destroy();
    die(http_response_code(403));
}

$comments = Profile::AddCommentToUser($_GET['toUser'], $_GET['content']);

Logs::AddLogs(
	"L'utilisateur ".$AUTHUSER['username']." à écrit un commentaire sur le profile ID (".$_GET['toUser'].") Contenue : (".$_GET['content'].")", 
	"primary", 
	"fa fa-paper-plane"
);

$webhookscontent = "L'utilisateur **".$AUTHUSER['username']."** (`".$AUTHUSER['discord_id']."`) à écrit un commentaire sur le profil (https://kvacdoor.cz/profile/".$_GET['toUser'].") Contenue : (".$_GET['content'].")";

$curl = curl_init("https://discord.com/api/webhooks/1076944832938909761/NNz7kRz1jILw-ezYmNUTSgA4LHg7_d1cKnRz6BBn98ePao7oc5I9J8UfsWn6uZiwo7qG");
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('content' => $webhookscontent)));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
$response = curl_exec($curl);
curl_close($curl);

?>