<?php

ini_set('memory_limit', '2048M');

if($AUTHUSER['roles'] != 3) {

	Logs::AddLogs(
		"User ".htmlentities($AUTHUSER['username'])." attempted to access a admin page (All Servers)", 
		"danger", 
		"fas fa-baby-carriage"
	);

	die(header('Location: /overview'));
}

$serverid = 1;
$nb_ply = 0;
$versions = [];
