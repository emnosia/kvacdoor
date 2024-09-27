<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

set_time_limit(300);
ini_set('memory_limit', '2048M');

// EVERY MINUTES !!
require_once dirname(__DIR__) . '/Models/includes.php';

$db = $GLOBALS['DB']->getPdo();


//
//  Update Playerlist to v4
//

// $servers = $db->query("SELECT id, playerlist FROM servers WHERE playerlist LIKE '%|||||%' LIMIT 250")->fetchAll();

// foreach ($servers as $server) {
//     $players = json_decode($server['playerlist']);
//     echo $server['playerlist'] . ' - ( ' . $server['id'] .' )<br>';
//     foreach ($players as $player) {
//         $split = explode('||||||', $player);
//         $data[] = [
//             'nick' => html_entity_decode($split[0]),
//             'steamid' => $split[2],
//             'usergroup' => $split[1],
//             'frags' => 0.0,
//             'death' => 0.0,
//             'ping' => 0.0,
//             'ip' => 'loopback',
//         ];
//     }
//     $q = $db->prepare("UPDATE servers SET playerlist = :player WHERE id = :id");
//     $q->execute(['id' => $server['id'], 'player' => json_encode($data)]);
//     $data = [];
// }


//
//  Update Username
//

// $users = $db->query("SELECT id, username, discriminator FROM users WHERE discriminator = 0 LIMIT 10")->fetchAll();

// foreach ($users as $user) {
//     $username = explode('#', html_entity_decode($user['username']));

//     if (is_numeric($username[1])) {
//         var_dump($username);
//         $q = $db->prepare('UPDATE users SET username = :username, discriminator = :discriminator WHERE id = :id');
//         $q->execute([
//             'id' => $user['id'],
//             'username' => html_entity_decode($username[0]),
//             'discriminator' => $username[1]
//         ]);
//     } else {
//         die('ID : ' . $user['id'] . '||| <br>ERROR!!!!!<br>ERROR!!!!!<br>ERROR!!!!!<br>ERROR!!!!!<br>ERROR!!!!!<br>ERROR!!!!!<br>ERROR!!!!!<br>ERROR!!!!!');
//     }
// }

//
//  Repair Payloads
//

// $payloads = $db->query("SELECT id, hostname FROM servers WHERE hostname LIKE '%&%' LIMIT 5000 OFFSET 20000")->fetchAll();

// foreach ($payloads as $payload) {
//     var_dump($payload['hostname']);
//     $q = $db->prepare('UPDATE servers SET hostname = :content WHERE id = :id');
//     $q->execute([
//         'id' => $payload['id'],
//         'content' => html_entity_decode($payload['hostname']),
//     ]);
// }

//
//  Repair Comments
//

// $comments = $db->query("SELECT id, content FROM comments WHERE content LIKE '%&%' LIMIT 50")->fetchAll();

// foreach ($comments as $comment) {
//     var_dump($comment['content']);
//     var_dump($comment['id']);
//     $q = $db->prepare('UPDATE comments SET content = :content WHERE id = :id');
//     $q->execute([
//         'id' => $comment['id'],
//         'content' => html_entity_decode($comment['content'], ENT_QUOTES),
//     ]);
// }

$leaders = $db->query("SELECT users.id, users.discord_id, users.avatar, users.username, users.roles, COUNT(servers.id) AS 'servers_nbr' FROM users LEFT JOIN servers ON users.id = servers.owner WHERE users.roles != 3 GROUP BY users.id ORDER BY servers_nbr DESC LIMIT 50")->fetchAll();
file_put_contents(dirname(dirname(__DIR__)) . "/data/leaders-50.json", json_encode($leaders));