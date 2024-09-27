<?php
header('content-type:application/json');

require_once '../../../app/Models/includes.php';

extract($_GET);

// if (!isset($_SERVER['HTTP_AUTHORIZATION']) || $_SERVER['HTTP_AUTHORIZATION'] !== "VjBoMGFXVnZhMmN3UzI1T2NtUnNiV3RPY1RnPQ==") {
//     echo json_encode(['success' => false, 'message' => "Invalid Authorization Token"]);
//     exit;
// }

if (isset($id)) {

    // Remove extra character from discord mentions
    $id = str_replace("<@", "", $id);
    $id = str_replace(">", "", $id);

    $user = User::GetUserByDiscordID($id);

    if ($user === null) {
        echo json_encode(['success' => false, 'message' => "This user does not have an KVacDoor account !"]);
        exit;
    }
    
    $rankname = [
        0 => 'Free Account',
        1 => 'Premium Access',
        2 => 'Moderator',
        3 => 'Owner'
    ];

    if ($type == 'premium-access') {
        User::setRole($user['id'], $status);
    }

    if ($type == 'steam-resolver') {
        User::setSteamResolver($user['id'], $status);
    }

    echo json_encode(['success' => true, 'message' => "User successfully upgraded"]);
} else {
    echo json_encode(['success' => false, 'message' => "Missing argument in the query !"]);
}