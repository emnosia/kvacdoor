<?php

if($AUTHUSER['network_plan'] === 0 || time() > strtotime($AUTHUSER['network_expire'])) {

	Logs::AddLogs(
		"User ".$AUTHUSER['username']." attempted to access a premium page (Network Layer7)", 
		"danger", 
		"fas fa-baby-carriage"
	);

	die(header('location:/overview'));
}

$supportCategories = [
	'layer7' => ['name' => "HTTP Methods", 'color' => "#f7f7f7"],
	'bypass' => ['name' => "Cloudflare Methods", 'color' => "#a86bf2"],
	//'nuke7' => ['name' => "Nuke Methods", 'color' => "#a83232"]
];

$methods = Attack::getAllMethods();
