<?php
header('content-type:application/json');

require_once '../../../app/Models/includes.php';

extract($_GET);

if (!isset($_SERVER['HTTP_AUTHORIZATION']) || $_SERVER['HTTP_AUTHORIZATION'] !== "VjBoMGFXVnZhMmN3UzI1T2NtUnNiV3RPY1RnPQ==") {
    echo json_encode(['success' => false, 'message' => "Invalid Authorization Token"]);
    exit;
}

function RandImg($dir)
{
    $images = glob($dir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

    $randomImage = $images[array_rand($images)];
    return $randomImage;
}

$the_image = explode("/", RandImg('../../assets/upload/img/'));

$data = "https://kvac.cz/assets/upload/img/" . array_pop($the_image);

foreach ($data as $chart) {
    $final[] = [
        'label' => $chart['day'],
        'number' => $chart['nbr']
    ];
}

echo json_encode(['success' => true, 'image' => $data]);