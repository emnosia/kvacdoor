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

$servers = Server::getAllFromUser($_SESSION['user']['id']);
$serverid = 1;
$data = [];


foreach ($servers as $server)
{
if($server['last_update'] + 130 < time()) continue;
?>
<tr>
    <th scope="row"><?= $serverid++ ?></th>
    <td><?= $server['hostname'] ?></td>
    <td><?= $server['ip'] ?></td>
    <td><?= $server['map'] ?></td>
    <td><?= $server['gamemode'] ?></td>
    <td><?= $server['player'] ?>/<?= $server['players'] ?></td>
    <td>
        <a href="/servers/<?= $server['id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-terminal"></i> Console</a>
    </td>
</tr>
<?php
}
?>