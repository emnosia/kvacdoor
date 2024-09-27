<?php
if($AUTHUSER['roles'] == 0) {

	Logs::AddLogs(
		"User ".$AUTHUSER['username']." attempted to access a premium page (History)", 
		"danger", 
		"fas fa-baby-carriage"
	);

	die(header('location:/overview'));
}

$serverid = 1;
