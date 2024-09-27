<?php

// allocate more ram and debug
ini_set("display_errors", 1);
error_reporting(E_ALL);
set_time_limit(300);
ini_set('memory_limit','2048M');

// import kvacdoor modules and functions
require_once dirname(__DIR__) . '/Models/includes.php';

// initialize database
$db = $GLOBALS['DB']->getPdo();

// select ip and number of connected player on the last 300 active servers
$servers = $db->query('SELECT ip, used_slots FROM servers ORDER BY last_update DESC LIMIT 300');

// push data to database
foreach ($servers as $server) {
    $slug = "servers-{$server['ip']}-analytics";

    $q = $db->prepare("INSERT INTO servers_statistics (slug, value) VALUES (:slug, :value)");
    $q->execute([
        'slug' => $slug,
        'value' => $server['used_slots'],
    ]);
}
