<?php
header('content-type:application/json');

require_once '../../../app/Models/includes.php';

extract($_GET);

// if (!isset($_SERVER['HTTP_AUTHORIZATION']) || $_SERVER['HTTP_AUTHORIZATION'] !== "VjBoMGFXVnZhMmN3UzI1T2NtUnNiV3RPY1RnPQ==") {
//     echo json_encode(['success' => false, 'message' => "Invalid Authorization Token"]);
//     exit;
// }

function RandImg($dir)
{
    $images = glob($dir . '*.{webm}', GLOB_BRACE);

    $randomImage = $images[array_rand($images)];
    return $randomImage;
}

$the_image = explode("/", RandImg('../../assets/upload/video/'));

$data = "https://kvac.cz/assets/upload/video/" . array_pop($the_image);

echo json_encode(['success' => true, 'image' => $data]);