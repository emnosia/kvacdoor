<?php
session_start();

echo 'POST';
var_dump($_POST);
echo "\n--------------\n";
echo 'GET';
var_dump($_GET);

file_put_contents("../assets/debug.txt", $_POST['data']);