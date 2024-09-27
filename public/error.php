<?php

if(isset($_GET["msg"]) AND !empty($_GET["msg"])){

	if($_GET["msg"] == "disable"){
		die('Votre Compte à été désactivé !');
	}

	if($_GET["msg"] == "unknown"){
		die('Ce Compte n\'existe pas !');
	}

} else {
	header('location:index.php');
}