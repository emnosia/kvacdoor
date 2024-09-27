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

$q = $_GET['q'];

$search = $GLOBALS['DB']->GetContent("logs", [], "WHERE content LIKE '%{$q}%' ORDER BY created_at DESC LIMIT 1000");

if (empty($q)) {
    echo json_encode(['success' => true, 'result' => Logs::GetLastLogs(1000)]);
    exit;
} 

echo json_encode(['success' => true, 'result' => $search]);