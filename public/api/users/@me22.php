<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['user']['id'])) {
    http_response_code(401);
    die(json_encode(['success' => false, 'message' => 'Not Authentified']));
}
require_once('../../../app/Models/includes.php');

// Recuperer la user concerner
$user = User::GetUser($_GET['id']);

// Afficher si elle existe et que l'utilisateur et son propriétaire
if(isset($user['id']))
{
	$data = array(
        'success' => true,
        'id' => (int)$user['id'],
        'email' => $user['email'],
        'username' => $user['username'],
        'discriminator' => (int)$user['discriminator'],
        'avatarUrl' => $user['avatar'],
        'is_premium' => ($user['roles'] >= 1),
        'is_admin' => ($user['roles'] >= 3),
        'is_banned' => ($user['ban'] == 1),
        'api_key' => $user['infectkey'],
        'created_at' => $user['created_at'],
        'updated_at' => $user['updated_at']
    );
    echo json_encode($data);
}
else
{
    die(json_encode(['success' => false, 'message' => 'Not Authorized']));
}