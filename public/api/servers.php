<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['user']['id'])) {
    http_response_code(401);
    die(json_encode(['success' => false, 'message' => 'Not Authentified']));
}
require_once('../../app/Models/includes.php');

function time_to_hours($Time)
{
    if ($Time < 3600) {
        $heures = 0;

        if ($Time < 60) {
            $minutes = 0;
        } else {
            $minutes = round($Time / 60);
        }
        $secondes = floor($Time % 60);
    } else {
        $heures = round($Time / 3600);
        $secondes = round($Time % 3600);
        $minutes = floor($secondes / 60);
    }

    $secondes2 = round($secondes % 60);

    $TimeFinal = "$heures h $minutes min $secondes2 s";
    return $TimeFinal;
}

if (isset($_GET['id']) && (int) $_GET['id'] !== 0)
{
    $server = Server::GetServer($_GET['id']);

    $date = new DateTime();
    $date->setTimestamp($server['last_update']);

    $data = [
        'id' => (int) $server['id'],
        'is_online' => ($server['last_update'] + 130 >= time()),
        'hostname' => $server['hostname'],
        'ip' => $server['ip'],
        'map' => $server['map'],
        'gamemode' => $server['gamemode'],
        'rcon' => $server['rcon'],
        'password' => $server['password'],
        'used_slots' => (int) $server['used_slots'],
        'max_slots' => (int) $server['max_slots'],
        'uptime' => time_to_hours($server['uptime']),
        'owner_id' => (int) $server['owner'],
        'last_ping' => $date->format('Y-m-d H:i:s'),
    ];
    echo json_encode($data);
}
else
{
    $servers = Server::getAllFromUser($_SESSION['user']['id']);
    $serverid = 1;
    $data = [];

    foreach ($servers as $server) {
        if ($server['last_update'] + 130 < time()) continue;
        $date = new DateTime();
        $date->setTimestamp($server['last_update']);

        $data[] = [
            'id' => (int) $server['id'],
            'ip' => $server['ip'],
            'hostname' => $server['hostname'],
            'map' => $server['map'],
            'gamemode' => $server['gamemode'],
            'used_slots' => (int) $server['used_slots'],
            'max_slots' => (int) $server['max_slots'],
            'last_ping' => $date->format('Y-m-d H:i:s'),
        ];
    }

    echo json_encode($data);
}
?>