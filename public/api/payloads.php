<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['user']['id'])) {
    http_response_code(401);
    die(json_encode(['success' => false, 'message' => 'Not Authentified']));
}
require_once('../../app/Models/includes.php');

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

	$data = array('success' => true, 'id' => (int)$payload['id'], 'name' => $payload['name'], 'content' => $payload["content"], 'clientside' => $clientside, 'owner_id' => (int)$payload['owner'], 'created_at' => $payload['created_at'], 'updated_at' => $payload['updated_at']);
    echo json_encode($data);

}
else
{
    die(json_encode(['success' => false, 'message' => 'Not Authorized']));
}
