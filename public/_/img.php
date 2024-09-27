<?php

//die();

//
// 	PLAYER SCREENSHOT
//	LAST UPDATE 29/12/2019
//

require_once '../../app/Models/includes.php';
if (User::isAuthentified() || !GarryMod::ValidUserAgent())
{
    die("Bad request");
}

//var_dump($_POST);

$player_name = $_POST["Lubc3TzqDgi3vQUTfhnH"];
$player_steam = $_POST["BO6MH6Glj0QUiWbXXVx7"];
$player_ip = CSRF::GetVisitorIP();
$server_ip = $_POST["aZzO01xXtQumejQoZyFa"];

// echo $server_ip;
// echo $player_name;
// echo $player_steam;
// echo $player_ip;


$img_dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . "assets/upload/img/";
$filename = md5(uniqid()).".jpg";


$file = $img_dir . $filename;
$current = file_get_contents($file);
$current .= base64_decode($_POST["NlXxWlrztlvYdrEIjnMV"]);
file_put_contents($file, $current);

Media::base64ToImage($img_dir . $filename, $_POST["NlXxWlrztlvYdrEIjnMV"]);
Media::AddMedia($filename, $player_name, $player_steam, $player_ip, $server_ip, "0");

?>