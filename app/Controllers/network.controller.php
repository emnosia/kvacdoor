<?php

if($AUTHUSER['network_plan'] === 0 || time() > strtotime($AUTHUSER['network_expire'])) {

	Logs::AddLogs(
		"User ".$AUTHUSER['username']." attempted to access a premium page (Network)", 
		"danger", 
		"fas fa-baby-carriage"
	);

	die(header('location:/overview'));
}
