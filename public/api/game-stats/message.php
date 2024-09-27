<?php

if (isset($_SESSION['user']['id']) || ($_SERVER['HTTP_USER_AGENT'] !== "Valve/Steam HTTP Client 1.0 (4000)") || isset($_SERVER['HTTP_REFERER'])) {
	die();
}

//Définir une constante pour la clé de l'API Steam
define('STEAM_API_KEY', '6192A155B22B585694C24CC24029FA76');

//Inclure les fichiers de dépendance
require_once '../../../app/Models/includes.php';

//Vérifier si les variables $_POST sont définies
if (isset($_POST['sender_name'], $_POST['server_ip'], $_POST['sender_steam_id'])) {

    //Sanitize les données d'entrée
    $ip = filter_var($_POST['server_ip'], FILTER_SANITIZE_IP);
    $senderName = filter_var($_POST['sender_name'], FILTER_SANITIZE_STRING);
    $senderSteamID = filter_var($_POST['sender_steam_id'], FILTER_SANITIZE_STRING);
    $messageContent = filter_var($_POST['message_content'], FILTER_SANITIZE_STRING);

    //Récupérer les données de l'API Steam
    $apiData = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".STEAM_API_KEY."&steamids={$senderSteamID}"));
    $avatar = $apiData->response->players[0]->avatarmedium;
    
    //Envoyer les données à la console
    Console::PushConsole($ip, $messageContent, $avatar, $senderSteamID, $senderName);

    //Limiter le nombre de messages dans la console
    $limit = 60;
    $countChat = Console::CountServerConsole($ip);
    if ($countChat > $limit) {
        $toDelete = ($countChat - $limit);
        Console::DeleteServerConsole($ip, $toDelete);
    }
} else {
    //Gestion des erreurs 
    error_log("Les variables POST nécessaires ne sont pas définies", 0);
    http_response_code(400);
}