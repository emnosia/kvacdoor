<?php
require_once '../app/Models/includes.php';

$url = $_GET['url'] ?? "";

Logs::AddLogs(
	"L'utilisateur ".htmlentities($AUTHUSER['username'])." à été rediriger vers (".htmlentities($url).")", 
	"warning", 
	"fa fa-rss"
);

header('Location:'. $url);