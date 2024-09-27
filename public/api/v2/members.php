<?php
header('content-type:application/json');
ini_set("display_errors", 1);
error_reporting(E_ALL);

// EVERY MINUTES !!
require_once '../../app/Models/includes.php';

// if (!isset($_GET['key']) || $_GET['key'] != "eXF73sTEQUcrU9qo==") {
//     die(json_encode(['success' => false, 'error' => 'Authentication Required']));
// }

extract($_GET);

if (isset($discord_id) && is_integer($discord_id)) {
    $user = User::GetUserByDiscordID($discord_id);
    $nbserver = Server::GetServerNumberFromUser($user['id']);

    $data = array('id' => $user['id'], 'username' => html_entity_decode($user['username']), 'avatar' => $user['avatar'], 'rank' => $user['grade'], 'nb_server' => $nbserver, 'last_connection' => $user['last_login']);
    echo json_encode($data);
}
