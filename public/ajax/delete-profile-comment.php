<?php

session_start();
if (!isset($_SESSION['user']['id'])) {
    die();
}

if (isset($_SESSION['user']['id'])) {
    require_once '../../app/Models/includes.php';
    if (!User::isAuthentified() || !CSRF::isAjaxRequest()) {
        die("Bad request");
    }

    Profile::deleteComment($_GET['id']);
}
