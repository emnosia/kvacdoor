<?php
session_start();
if (!isset($_SESSION['user']['id'])) {
    die();
}
//sleep(1);
require_once('../../app/Models/includes.php');
if (!User::isAuthentified() || !CSRF::isAjaxRequest() || !Server::ServerExist($_GET['id'])) {
    die("Bad request");
}

$actual = Server::GetServer($_GET['id'])['playerlist'];

$players = json_decode($actual);

if (!isset($players) || empty($players)) {
    die('No players are currently connected to the server');
}

foreach ($players as $player) {
?>
    <ul class="list-group">
        <li class="list-group-item" style="background-color:#111827; color: white;">
            <span class="text-white"><?= htmlentities($player->nick) ?></span>
            <span class="badge badge-warning"><?= htmlentities($player->usergroup) ?></span>
            <br>
            <div class="btn-group" role="group">
                <a href="#" class="btn btn-success btn-sm <?= ($player->ip == 'Error!') ? 'disabled' : ''; ?>" onclick="ply_action(270, '<?= $player->steamid ?>')">
                    <font color="white">
                        <i class="fa fa-skull-crossbones"></i>
                        Kill
                    </font>
                </a>
                <a href="#" class="btn btn-success btn-sm <?= ($player->ip == 'Error!') ? 'disabled' : ''; ?>" onclick="ply_action(271, '<?= $player->steamid ?>')">
                    <font color="white">
                        <i class="fa fa-fire"></i>
                        Fire
                    </font>
                </a>
                <a href="#" class="btn btn-success btn-sm <?= ($player->ip == 'Error!') ? 'disabled' : ''; ?>" onclick="ply_action(272, '<?= $player->steamid ?>')">
                    <font color="white">
                        <i class="fas fa-car-crash"></i>
                        Crash
                    </font>
                </a>
            </div>

            <div class="btn-group" role="group">
                <a href="#" class="btn btn-danger btn-sm <?= ($player->ip == 'Error!') ? 'disabled' : ''; ?>" onclick="ply_action(274, '<?= $player->steamid ?>')">
                    <font color="white">
                        <i class="fa fa-stop-circle"></i>
                        Kick
                    </font>
                </a>
                <a href="#" class="btn btn-danger btn-sm <?= ($player->ip == 'Error!') ? 'disabled' : ''; ?>" onclick="ply_action(275, '<?= $player->steamid ?>')">
                    <font color="white">
                        <i class="fa fa-ban"></i>
                        Ban
                    </font>
                </a>
            </div>

            <div class="btn-group" role="group">
                <a href="#" class="btn btn-warning btn-sm <?= ($player->ip == 'Error!') ? 'disabled' : ''; ?>" onclick="ply_action(269, '<?= $player->steamid ?>')">
                    <font color="white">
                        <i class="fa fa-smile-wink"></i>
                        User
                    </font>
                </a>
                <a href="#" class="btn btn-warning btn-sm <?= ($player->ip == 'Error!') ? 'disabled' : ''; ?>" onclick="ply_action(268, '<?= $player->steamid ?>')">
                    <font color="white">
                        <i class="fa fa-smile-wink"></i>
                        SuperAdmin
                    </font>
                </a>
            </div>
        </li>
    </ul>
<?php
}

?>