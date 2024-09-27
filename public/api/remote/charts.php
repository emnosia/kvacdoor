<?php
header('content-type:application/json');

require_once '../../../app/Models/includes.php';

extract($_GET);

if (!isset($_SERVER['HTTP_AUTHORIZATION']) || $_SERVER['HTTP_AUTHORIZATION'] !== "VjBoMGFXVnZhMmN3UzI1T2NtUnNiV3RPY1RnPQ==") {
    echo json_encode(['success' => false, 'message' => "Invalid Authorization Token"]);
    exit;
}

if (isset($id)) {

    // Remove extra character from discord mentions
    $id = str_replace("<@", "", $id);
    $id = str_replace(">", "", $id);

    $user = User::GetUserByDiscordID($id);

    // if (!$user) {
    //     echo json_encode(['success' => false, 'message' => "Users Not Found"]);
    //     exit;
    // }

    $data = Stat::SelectLastData($user['id'], 14);
    
    foreach ($data as $chart) {
        $final[] = [
            'label' => $chart['day'],
            'number' => $chart['nbr']
        ];
    }
    
    echo json_encode(['success' => true, 'username' => $user['username'], 'data' => $final]);
} else {
    echo json_encode(['success' => false, 'message' => "Specify a user"]);
}