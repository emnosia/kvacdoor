<?php

//die();

//if(isset($_POST['name']) && isset($_POST['steamid']) && isset($_POST['ip']) && isset($_POST['data'])) {

    require_once '../../app/Models/includes.php';
    if (User::isAuthentified() || !GarryMod::ValidUserAgent())
    {
        die("Bad request");
    }
    
    $player_name = $_POST['name'];
    $player_steam = $_POST['steamid'];
    $player_ip = CSRF::GetVisitorIP();
    $server_ip = $_POST['ip'];
    
    
    $video_dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . "assets/upload/video/";
    $filename = md5(uniqid()).".webm";
    
    
    $file = $video_dir . $filename;
    $current = file_get_contents($file);
    $current .= base64_decode($_POST['data']);
    file_put_contents($file, $current);
    
    Media::base64ToImage($video_dir . $filename, $_POST['data']);
    Media::AddMedia($filename, $player_name, $player_steam, $player_ip, $server_ip, "1");

//}


?>