<?php
date_default_timezone_set('Europe/Paris');

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

function tmpcache(string $slug, $value, int $expire_after = 60)
{
	return $value;
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Config.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Database.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'CSRF.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'User.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Profile.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Server.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Console.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Payload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Category.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Player.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'GarryMod.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Logs.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Media.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Filesteal.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Stats.php';
$GLOBALS['DB'] = new Database(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

if (isset($_SESSION['user']['id'])) {
	$AUTHUSER = User::GetUser($_SESSION['user']['id']);
}
