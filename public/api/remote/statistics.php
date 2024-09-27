<?php
header('content-type:application/json');

require_once '../../../app/Models/includes.php';

extract($_GET);

if (!isset($_SERVER['HTTP_AUTHORIZATION']) || $_SERVER['HTTP_AUTHORIZATION'] !== "VjBoMGFXVnZhMmN3UzI1T2NtUnNiV3RPY1RnPQ==") {
    echo json_encode(['success' => false, 'message' => "Invalid Authorization Token"]);
    exit;
}

$data = array('success' => true, 'premium' => $GLOBALS['DB']->Count("users", ['roles' => 1]), 'members' => $GLOBALS['DB']->Count("users"), 'servers' => floor($GLOBALS['DB']->Count("servers")));
echo json_encode($data);
