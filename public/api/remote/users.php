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

    $nbserver = Server::countFromUser($user['id']);
    
    $rankname = [
        0 => 'Free Account',
        1 => 'Premium Access',
        2 => 'Moderator',
        3 => 'Owner'
    ];

    $data = array(
        'success' => true,
        'id' => (int)$user['id'],
        'discord_id' => (int)$user['discord_id'],
        'username' => html_entity_decode($user['username']),
        'discriminator' => (int)$user['discriminator'],
        'avatar' => $user['avatar'],
        'rank_id' => (int)$user['roles'],
        'rank_name' => $rankname[$user['roles']],
        'steam_resolver' => (bool)$user['xray'],
        'network_access' => ($user['network_plan'] !== 0 && strtotime($user['network_expire']) > time()),
        'nb_server' => (int)$nbserver,
        'last_connection' => $user['last_login'],
        'created_at' => $user['created_at']
    );
    echo json_encode($data);
} else {
    echo json_encode(['success' => false, 'message' => "Missing argument in the query !"]);
}