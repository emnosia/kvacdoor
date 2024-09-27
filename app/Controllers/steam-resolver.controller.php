<?php

if($AUTHUSER['xray'] != 1) {

	Logs::AddLogs(
		"User ".htmlentities($AUTHUSER['username'])." attempted to access Steam resolver tool without subscription.", 
		"danger", 
		"fas fa-baby-carriage"
	);

	die(header('location:/overview'));	
}
?>