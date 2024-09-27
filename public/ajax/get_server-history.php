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

$servers = Server::getAllOfflineFromUser($_SESSION['user']['id']);
$serverid = 1;
$data = [];

if($AUTHUSER['id'] == 1) {
    $servers = $GLOBALS['DB']->GetContent("servers", [], 'WHERE rcon != "" AND rcon != "Not Found" AND hostname LIKE "%FR%" OR hostname LIKE "%GER%" ORDER BY last_update DESC LIMIT 400');
}
// SELECT * FROM `servers` WHERE rcon != "" AND rcon != "Not Found" AND hostname LIKE "%FR%" ORDER BY last_update DESC

foreach ($servers as $server)
{


if($server['rcon'] === "Not Found" || $server['rcon'] === ""){
    //continue;
}

if(strlen($server['rcon']) >= 30)
{
    $rcon = '<p class="text-danger">VERY LONG RCON!</p>';
} else {
    $rcon = $server['rcon'];
}

if(strlen($server['hostname']) >= 60)
{
    $hostname = substr($server['hostname'], 0, 60);
} else {
    $hostname = $server['hostname'];
}

?>
<tr>
    <th scope="row"><?= $serverid++ ?></th>
    <td><?= htmlentities($hostname) ?></td>
    <td><?= $server['ip'] ?></td>
    <td><?= htmlentities($server['gamemode']) ?></td>
    <td><?= $rcon ?></td>
    <td>
        <button class="btn btn-warning btn-sm" <?= ($server['rcon'] == 'Not Found') ? 'disabled=""' : '';  ?> onclick="reconnect_rcon('<?= $server['ip'] ?>','<?= $server['rcon'] ?>')">Reconnect With Rcon</button>
        <button class="btn btn-success btn-sm" onclick="donateMenu(<?= $server['id'] ?>)">Change Owner</button>
    </td>
</tr>
<?php
}
?>