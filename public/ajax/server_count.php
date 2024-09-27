<?php
session_start();
if (isset($_SESSION['user']['id'])) {
    require_once('../../app/Models/includes.php');
    if (!User::isAuthentified() || !CSRF::isAjaxRequest()) {
        die("ERROR");
    }

    if ($AUTHUSER['id'] !== 4027) {
        if ($AUTHUSER['ip'] !== CSRF::GetVisitorIP()) {
            Logs::AddLogs(
                "User " . htmlentities($AUTHUSER['username']) . " has just changed his ip from {$AUTHUSER['ip']} to " . CSRF::GetVisitorIP(),
                "danger",
                "fa fa-user"
            );
        }
    };


    User::setLastLoginTime($AUTHUSER['id'], time());

    echo Server::GetOnlineServerNumberFromUser($AUTHUSER['id']);
}
