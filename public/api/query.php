<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['user']['id'])) {
    http_response_code(401);
    die(json_encode(['success' => false, 'message' => 'Not Authentified']));
}
if (!isset($_GET['ip']) || !isset($_GET['port']))
{
    die(json_encode(['success' => false, 'message' => "Invalid parameters"]));
}

// RateLimit
if($_SESSION["ratelimit"]["time"] != date("s") or !isset($_SESSION["ratelimit"])){
    $_SESSION["ratelimit"] = array("time" => date("s"), "rate" => 0);
}

$_SESSION["ratelimit"]['rate'] = $_SESSION["ratelimit"]['rate'] + 1;

if($_SESSION["ratelimit"]['rate'] >= 2){
	die(json_encode(['success' => false, 'message' => "User Rate Limit Exceeded"]));
}

require dirname(__DIR__) . "/app/Models/includes.php";
require dirname(__DIR__) . "/app/Vendor/SourceQuery/bootstrap.php";

use xPaw\SourceQuery\SourceQuery;

// Edit this ->
define('SERVER_IP', $_GET['ip']);
define('SERVER_PORT', $_GET['port']);

$server = $GLOBALS['DB']->GetContent("servers", ['ip' => SERVER_IP . ":" . SERVER_PORT])[0];

$query = new SourceQuery();

try {
    $query->Connect(SERVER_IP, SERVER_PORT, 1);
    $server = $query->GetInfo();
    // var_dump($server);
    $data = [
        'is_online' => (isset($server['Version'])),
        'ip' => SERVER_IP . ":" . SERVER_PORT,
        'server' => [
            'hostname' => $server['HostName'],
            'map' => $server['Map'],
            'gamemode' => strtolower($server['ModDesc']),
            'bots' => $server['Bots'],
            'used_slots' => $server['Players'],
            'max_slots' => $server['MaxPlayers'],
            'vac' => $server['Secure'],
            'password' => $server['Password'],
            'version' => $server['Version'],
        ]
    ];
} catch (Exception $e) {
    $data = ['is_online' => false, 'ip' => SERVER_IP . ":" . SERVER_PORT];
} finally {
    $query->Disconnect();
}

echo json_encode($data);
