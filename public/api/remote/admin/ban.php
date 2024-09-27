<?php
header('content-type:application/json');

require_once '../../../../app/Models/includes.php';

extract($_GET);

if (!isset($_SERVER['HTTP_AUTHORIZATION']) || $_SERVER['HTTP_AUTHORIZATION'] !== "VjBoMGFXVnZhMmN3UzI1T2NtUnNiV3RPY1RnPQ==") {
    echo json_encode(['success' => false, 'message' => "Invalid Authorization Token"]);
    exit;
}

$id = str_replace("<@", "", $id);
$id = str_replace(">", "", $id);

$user = User::GetUserByDiscordID($id);

// sleep(30);

if ($user['grade'] == 3) {
    echo json_encode(['success' => false, 'message' => "You cannot ban an **Panel Administrator**"]);
    exit;
}
// echo json_encode(['user' => $id, 'status ' => $status]);
// exit;

if ($status == 'true') {
    if ($user['ban'] == 0) {
        User::BanUser($user['id'], "Banned using KVacDoor API v2");
        echo json_encode(['success' => true, 'message' => $user['username'] . " has been successfully banned from KVacDoor"]);
    } else {
        echo json_encode(['success' => false, 'message' => $user['username'] . " is already banned from KVacDoor"]);
    }
} else {
    if($user['ban'] == 1) {
        User::UnbanUser($user['id']);
        echo json_encode(['success' => true, 'message' => $user['username'] . " has been successfully unbanned from KVacDoor"]);
    } else {
        echo json_encode(['success' => false, 'message' => $user['username'] . " is not banned from the panel"]);
    }
}