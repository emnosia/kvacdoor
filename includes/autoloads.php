<?php
session_start();

// if ($_SESSION['user']['id'] != 1) {
// 	require dirname(__DIR__) . "/public/maintenance.php";
// 	die();
// }

// if (!isset($_SESSION['user']['id']) || $_SERVER['HTTP_HOST'] != "kvacdoor.cz") {
// 	die(header('Location:https://kvacdoor.cz/login?returnUrl=' . urlencode($_SERVER["REQUEST_URI"])));
// }

require_once 'constants.php';
require_once '../app/Models/includes.php';

// Redirige l'utilisateur si il n'est pas authentifier ou banni
if (User::isBanned($_SESSION['user']['id']) || !User::isExist($_SESSION['user']['id'])) {
    User::logout();
    header('location:/');
    exit;
}

$currentPage = substr($_SERVER["SCRIPT_NAME"], 1, -4);

if (file_exists(CONTROLLER_PATH . $currentPage . '.controller.php')) {
    require_once CONTROLLER_PATH . $currentPage . '.controller.php';
}

ob_start();

if (file_exists(VIEW_PATH . $currentPage . '.view.php')) {
    require_once VIEW_PATH . $currentPage . '.view.php';
}

$pageContent = ob_get_clean();

require_once LAYOUT_PATH . 'manager.view.php';
