<?php 

if ($AUTHUSER['roles'] == 0) {
    header('location:/pricing');
    exit;
}

$day = date('d');
$month = date('m');

$leaders = json_decode(file_get_contents(dirname(dirname(__DIR__)) . '/data/leaders.json'), true);
