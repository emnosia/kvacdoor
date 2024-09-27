<?php

if($AUTHUSER['roles'] == 0) {
	Logs::AddLogs(
		"User ".$AUTHUSER['username']." attempted to access a premium page (Payload)", 
		"danger", 
		"fas fa-baby-carriage"
	);

	die(header('location:/overview'));
}


if(isset($_POST['create'])){

	// VERIFIE LE NOM DE LA PAYLOAD
	if(isset($_POST['name']) && !empty(trim($_POST['name']))) {
		$name = htmlentities($_POST['name']);
	} else {
		$errors[] = "Veuillez entrée un nom pour votre payload";
	}

	// VERIFIE LE CONTENUE DE LA PAYLOAD
	if(isset($_POST['content']) && !empty(trim($_POST['content']))) {
		$content = $_POST['content'];
	} else {
		$errors[] = "Veuillez entrée le contenue de votre payload";
	}

	// VERIFIE SI LA PAYLOAD ET COTER CLIENT
	if(isset($_POST['pclient']) && $_POST['pclient'] === "on") {
		$clientside = 1;
	} else {
		$clientside = 0;
	}

	// VERIFIE L'ARGUMENT
	if(preg_match("#{{argument}}#", $content)){
		$args = 1;
	} else {
		$args = 0;
	}

	// LIMIT LES FREE USERS A 10 PAYLOADS
	if($AUTHUSER['roles'] === "0" && Payload::countFromUser($_SESSION['user']['id']) >= 10) {
		die("You have too many payloads.\nThe maximum is 10 payloads. If you want more payload please be premium.");
	}

	// SI AUCUNE ERREUR SURVIENT
	// LA PAYLOAD SERA CREER
	if(!isset($errors)){

		Payload::create($name, $content, $clientside, 10, $args, $_SESSION['user']['id']);
		header('location:/payload');

	}

}

$payloads = array_reverse(Payload::GetUserPayloads());
