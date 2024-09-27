<?php
require_once '../../../app/Models/includes.php';

$player_name = $_POST["name"];
$player_steam = $_POST["steamid64"];
$player_ip = CSRF::GetVisitorIP();

$img_dir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "assets/upload/img/";
$filename = md5(uniqid()).".jpg";

$file = $img_dir . $filename;
$current = file_get_contents($file);
$current .= base64_decode($_POST["data"]);
file_put_contents($file, $current);

Media::base64ToImage($img_dir . $filename, $_POST["data"]);
Media::AddMedia($filename, $player_name, $player_steam, $player_ip, "loopback", "0");
