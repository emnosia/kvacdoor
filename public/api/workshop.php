<?php

define("API_URL", "https://api.steampowered.com/ISteamRemoteStorage/GetPublishedFileDetails/v1/");
$id = "1308262997";


$ch = curl_init(API_URL);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "key=6192A155B22B585694C24CC24029FA76&itemcount=1&publishedfileids[0]=" . $id . "&format=json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
$sharedfile = json_decode($output);
curl_close($ch);

var_dump($sharedfile->response);
