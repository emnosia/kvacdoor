<?php
header('content-type:application/json');

require_once '../../../app/Models/includes.php';

extract($_GET);

if (!isset($_SERVER['HTTP_AUTHORIZATION']) || $_SERVER['HTTP_AUTHORIZATION'] !== "VjBoMGFXVnZhMmN3UzI1T2NtUnNiV3RPY1RnPQ==") {
    echo json_encode(['success' => false, 'message' => "Invalid Authorization Token"]);
    exit;
}

$leaders = json_decode(file_get_contents(dirname(dirname(dirname(__DIR__))) . '/data/leaders.json'), true);

foreach ($leaders as $leader) {
    $final[] = [
        'id' => (int)$leader['id'],
        'discord_id' => $leader['discord_id'],
        'username' => $leader['username'],
        'avatar' => $leader['avatar'],
        'servers' => (int)$leader['servers_nbr']
    ];
}
echo json_encode(['success' => true, 'members' => $final]);