<?php
session_start();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// session_unset();
// session_destroy();


header('Content-Type: application/json');
if (!isset($_SESSION['user']['id'])) {
    http_response_code(401);
    die(json_encode(['success' => false, 'message' => 'Not Authentified']));
}
require_once('../../app/Models/includes.php');

if (isset($_GET['id']) && (int) $_GET['id'] !== 0)
{
    $player = Player::GetPlayer($_GET['id']);

    $steam = Player::getSteamProfile($player['steamid64']);

    if ($player['whitelist'] == 0 || $_SESSION['admin_mode'] == 1) {
        $output = Player::ipMap($player['ip']);
    } else {
        $output = null;
        $player['last_server'] = "loopback";
    }

    $info_ip = json_decode($output);

    $data = [
        'id' => (int)$player['id'],
        'steam' => [
            'id' => $player["steamid64"],
            'name' => htmlentities($steam->personaname),
            'avatar' => $steam->avatarfull,
            'url' => $steam->profileurl,
        ],
        'location' => [
            'country' => $info_ip->country ?? null,
            'region' => $info_ip->regionName ?? null,
            'city' => $info_ip->city ?? null,
            'zip' => $info_ip->zip ?? null,
            'isp' => $info_ip->as ?? null,
        ],
        'blacklist' => (bool)$player["blacklist"],
        'last_server' => $player["last_server"],
        'updated_at' => date('Y-m-d H:i:s' , $player["updated_at"]),
        'created_at' => $player['created_at']
        //'created_at' => date('d/m/Y à H:i:s' ,strtotime($player["register_date"]))
    ];
    echo json_encode($data);
}