<?php
//ini_set("display_errors", 1);
//error_reporting(E_ALL);
require_once '../app/Models/includes.php';
if (User::isAuthentified() || !GarryMod::ValidUserAgent() || !isset($_POST['ip']) || !isset($_POST['msg']) || empty(trim($_POST['ip'])) || !GarryMod::ValidIP_Port($_POST['ip']))
{
    die("Accès non autorisé. Les administrateurs ont été averti de votre présence sur une page dont vous ne disposez pas l'accès.");
    Logs::AddLogs('Accèes non autorisé sur la page : post-console.php', 'orange', 'fas fa-baby');
}

//if(empty(trim($_POST['msg']))) die('-- response 200');

$ip = htmlentities($_POST['ip']);
$msgs = explode("\xFF", $_POST['msg']);

$limit = 30;

foreach ($msgs as $msg) {
	if($msg !== "")
	{
		Console::PushConsole($ip, $msg);
	}
}

$CountChat = Console::CountServerConsole($ip);

if($CountChat > $limit){
	$limit = ($CountChat - $limit);
	Console::DeleteServerConsole($ip, $limit);
}

?>