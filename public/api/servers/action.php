<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
if (!isset($_SESSION['user']['id'])) {
    http_response_code(401);
    die(json_encode(['success' => false, 'message' => 'Not Authentified']));
}
require_once('../../../app/Models/includes.php');

if (isset($_GET['payload']) && (int) $_GET['payload'] !== 0)
{

    $payload = Payload::get($_GET['payload']);
    $serverinfo = Server::GetServer($_GET['server']);
    
    if($payload['clientside'] == 1) {
        include '../../../data/clientside.php';
        $payload['content'] = $clientside_start.$payload['content'].$clientside_end;
    }
    
    $argument = (preg_match("#{{argument}}#", $payload['content']));
    
    if($argument && !isset($_GET['argument'])) {
        die(json_encode(['success' => false, 'required_argument' => true, 'help_argument' => $payload['tips'] ?? null]));
    } elseif($argument) {
        $payload['content'] = str_replace("{{argument}}", $_GET['argument'], $payload['content']);
    }

    Payload::SendPayloadToServerID($_GET['server'], $payload['content']);
    echo json_encode(['success' => true]);

    Logs::AddLogs(
        "User ".htmlentities($AUTHUSER['username'])." executed payload (".htmlentities($payload['name']).") on server ".htmlentities($serverinfo['hostname']), 
        "info", 
        "fas fa-paper-plane"
    );
} else {
    echo json_encode(['success' => false, 'required_argument' => false]);
}
