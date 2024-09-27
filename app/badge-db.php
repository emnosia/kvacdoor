<?php
require_once 'Models/includes.php';

$db = $GLOBALS['DB']->getPdo();

// $leaders = $db->query("SELECT users.id, users.discord_id, users.avatar, users.username, users.grade, COUNT(servers.id) AS 'servers_nbr' FROM users LEFT JOIN servers ON users.id = servers.owner GROUP BY users.id ORDER BY servers_nbr DESC LIMIT 20")->fetchAll();
// var_dump($leaders);

$users = $db->query("SELECT * FROM users WHERE id < 350")->fetchAll();

//var_dump($users);

foreach ($users as $user) {

    $badge = $db->query("SELECT * FROM users_badges WHERE user_id = {$user['id']} AND badge_id = 2")->fetch();


    if ($badge === false) {
        
        $db->query("INSERT INTO users_badges (user_id, badge_id) VALUES ('{$user['id']}', '2')");

        echo $user['id'] . "<br>";
        echo $user['username'] . "<br>";
        echo $user['discord_id'] . "<br>";
        break;
    }

}
