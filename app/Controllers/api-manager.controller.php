<?php

if($AUTHUSER['network_plan'] !== 3 || time() > strtotime($AUTHUSER['network_expire']) || $AUTHUSER['roles'] !== 3) {

	Logs::AddLogs(
		"User ".$AUTHUSER['username']." attempted to access a premium page (API Manager)", 
		"danger", 
		"fas fa-baby-carriage"
	);

	die(header('location:/overview'));
}
