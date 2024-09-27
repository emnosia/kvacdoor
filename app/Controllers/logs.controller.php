<?php 
if($AUTHUSER['roles'] != 3) {

	Logs::AddLogs(
		"User ".$AUTHUSER['username']." attempted to access a admin page (Logs)", 
		"danger", 
		"fas fa-baby-carriage"
	);

	die(header('location:/overview'));
}
