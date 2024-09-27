<?php

if($AUTHUSER['network_plan'] === 0 || time() > strtotime($AUTHUSER['network_expire'])) {

	Logs::AddLogs(
		"User ".$AUTHUSER['username']." attempted to access a premium page (Network Layer4)", 
		"danger", 
		"fas fa-baby-carriage"
	);

	die(header('location:/overview'));
}

$supportCategories = [
	'layer4' => ['name' => "Server Methods", 'color' => "#f7f7f7"],
	'gaming' => ['name' => "Game Methods", 'color' => "#8987ff"],
	'hosting' => ['name' => "Host Methods", 'color' => "#a86bf2"],
	'nuke4' => ['name' => "Nuke Methods", 'color' => "#a83232"]
];

$methods = Attack::getAllMethods();