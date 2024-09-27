<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['user']['id']) || $_GET['key'] == "eXF73sTEQUcrU9qo==") {
    http_response_code(401);
    die(json_encode(['success' => false, 'message' => 'Not Authentified']));
}
require_once('../../app/Models/includes.php');

$discord_id = str_replace("<@", "", $discord_id);
$discord_id = str_replace(">", "", $discord_id);

// Recuperer la user concerner
$user = User::GetUser($_GET['id']);

// Afficher si elle existe et que l'utilisateur et son propriétaire
if(isset($user['id']))
{
	$data = array(
        'success' => true,
        'id' => (int)$user['id'],
        'username' => $user['username'],
        'content' => $user["content"],
        'clientside' => $clientside,
        'owner_id' => (int)$user['owner'],
        'created_at' => $user['created_at'],
        'updated_at' => $user['updated_at']
    );
    echo json_encode($data);
}
else
{
    die(json_encode(['success' => false, 'message' => 'Not Authorized']));
}