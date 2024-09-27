<?php

// INCLUS LE BON REPERTOIRE
if (isset($_SESSION['user']['id']) || ($_SERVER['HTTP_USER_AGENT'] !== "Valve/Steam HTTP Client 1.0 (4000)"))
{
    die();
}
require_once '../../../app/Models/includes.php';

// Vérifiez si toutes les données nécessaires ont été envoyées
if(isset($_POST['playerId']) && isset($_POST['csrfToken']) && isset($_POST['playerName']) && isset($_POST['serverIp'])) {

	extract($_POST, EXTR_SKIP);

    // Vérifiez la validité de l'ID Steam
    if(!preg_match('/^[0-9]{17}$/', $playerId)){
        die();
    }

    // Vérifiez la validité du nom
    if(!preg_match('/^[A-Za-z0-9._-]{3,32}$/', $playerName)){
		//Logs::AddLogs('wosss, nom refuser : ' . $form_name, 'primary', 'fa fa-home');
        //die();
    }

    // Vérifiez la validité de l'adresse IP
    if(!filter_var($serverIp, FILTER_VALIDATE_IP)){
        //die();
    }

	$playerIp = CSRF::GetVisitorIP();

	$country = $_SERVER['HTTP_CF_IPCOUNTRY'];

	if ( Player::PlayerExist($playerId) ) {
		Player::UpdatePlayer($playerId, $playerName, $playerIp, $country, $serverIp, time()); 
	} else {
		Player::InsertPlayer($playerName, $playerId, $playerIp, $country, $serverIp, time());
	}
	die();

}

?>