<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die('Bad Request');
}
header('Content-Type: application/json');
require_once '../../app/Models/includes.php';
if (!User::isAuthentified() || !CSRF::isAjaxRequest())
{
	http_response_code(400);
    die(json_encode("Bad request"));
}

// Recuperer la payload concerner
$payload = Payload::get($_GET['id']);

// Afficher si elle existe et que l'utilisateur et son propriétaire
if($payload['owner'] == $_SESSION['user']["id"])
{

	if($payload["clientside"] == 0){
		$clientside = false;
	} else {
		$clientside = true;
	}

	$data = array('name' => $payload['name'], 'content' => $payload["content"], 'clientside' => $clientside,);
    echo json_encode($data);

}
else
{
	http_response_code(400);
	die(json_encode("Bad request"));
}

?>