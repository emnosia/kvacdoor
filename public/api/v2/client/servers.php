<?php

// endpoint : https://kvacdoor.cz/api/v1/client/servers?count=1

header('Content-Type: application/json');

require_once('../../../app/Models/includes.php');

if (!User::isAuthentified() || !CSRF::isAjaxRequest())
{
    //die(CSRF::BadRequestJson());
}

User::UpdateLoginTime($AUTHUSER['id'], time());

echo json_encode(['success' => true, 'count' => Server::GetOnlineServerNumberFromUser($AUTHUSER['id']) ]);
